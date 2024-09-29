<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function index(Request $request)
    {
        return \Cache::remember('products', 60*30, function() use($request) {
            sleep(2);
            $query = Product::query();

            if ($s = $request->input('s')) {
                $query->whereRaw("title LIKE '%{$s}%'")
                    ->orWhereRaw("description LIKE '%{$s}%'");
            }

            return ProductResource::collection($query->get());
        });
    }
}
