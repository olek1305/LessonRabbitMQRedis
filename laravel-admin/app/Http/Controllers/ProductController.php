<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    public function show($id): ProductResource
    {
        return new ProductResource(Product::find($id));
    }

    public function store(ProductCreateRequest $request): JsonResponse
    {
        $product = Product::create($request->only('title', 'description', 'price', 'image'));

        return response()->json(new ProductResource($product), 201);
    }

    public function update($id, Request $request): JsonResponse
    {
        $product = Product::findOrFail($id);

        $product->update($request->only('title', 'description', 'price', 'image'));

        return response()->json(new ProductResource($product), 200);
    }

    public function delete($id): JsonResponse
    {
        Product::destroy($id);

        return response()->json([
            'message' => 'Product got deleted',
            'id' => $id
        ], 204);
    }
}
