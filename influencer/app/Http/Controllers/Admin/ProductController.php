<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('view', 'users');

        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id): ProductResource
    {
        Gate::authorize('view', 'users');

        return new ProductResource(Product::find($id));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(ProductCreateRequest $request): JsonResponse
    {
        Gate::authorize('edit', 'users');

        $product = Product::create($request->only('title', 'description', 'price', 'image'));

        return response()->json(new ProductResource($product), 201);
    }

    /**
     * @throws AuthorizationException
     */
    public function update($id, Request $request): JsonResponse
    {
        Gate::authorize('edit', 'users');

        $product = Product::findOrFail($id);

        $product->update($request->only('title', 'description', 'price', 'image'));

        return response()->json(new ProductResource($product), 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        Gate::authorize('edit', 'users');

        Product::destroy($id);

        return response()->json([
            'message' => 'Product got deleted',
            'id' => $id
        ], 204);
    }
}
