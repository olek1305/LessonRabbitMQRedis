<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController
{
    public function index(Request $request)
    {
        $products = \Cache::remember('products', 60*30, function() use($request) {
            sleep(2);

            return Product::all();
        });

        if ($s = $request->input('s')) {
            $products = $products->filter(function(Product $product) use($s) {
                return Str::contains($product->title, $s) || Str::contains($product->description, $s);
            });
        }

        return ProductResource::collection($products);
    }
}
