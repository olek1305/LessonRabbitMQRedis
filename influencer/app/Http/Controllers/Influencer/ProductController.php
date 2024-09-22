<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Product::query();

        if ($s = $request->input('s')) {
            $query->whereRaw("title LIKE '%{$s}%'")
                ->orWhereRaw("description LIKE '%{$s}%'");
        }

        return ProductResource::collection($query->get());
    }
}
