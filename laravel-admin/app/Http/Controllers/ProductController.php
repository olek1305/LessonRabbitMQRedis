<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function store(Request $request)
    {
        //
    }

    public function update($id, Request $request)
    {
        //
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
