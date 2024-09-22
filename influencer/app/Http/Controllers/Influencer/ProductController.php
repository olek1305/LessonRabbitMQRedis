<?php

namespace App\Http\Controllers\Influencer;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController
{
    public function index(): Collection
    {
        return Product::all();
    }
}
