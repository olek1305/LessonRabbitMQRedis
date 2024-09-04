<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Str;

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

    public function store(Request $request): Application|Response|JsonResponse|ResponseFactory
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
           'image' => 'required|image'
        ]);

        if($file = $request->file('image')){
            $name = Str::random(10);
            $url = $file->storeAs('images', $name . '.' . $file->extension(), 'public');
            $fullUrl = Storage::url($url);
        } else {
            return response(['error' => 'Image upload failed.'], 422);
        }

        $product = Product::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $fullUrl,
            'price' => $validated['price'],
        ]);

        return response(new ProductResource($product), 201);
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
