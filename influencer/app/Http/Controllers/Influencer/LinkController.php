<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\LinkProduct;
use Illuminate\Http\Request;

class LinkController
{
    public function store(Request $request): LinkResource
    {
        $link = Link::create([
           'user_id' => $request->user()->id,
           'code' => \Str::random(10),
        ]);

        foreach ($request->input('products') as $product_id) {
            LinkProduct::create([
                'link_id' => $link->id,
                'product_id' => $product_id,
            ]);
        }

        return new LinkResource($link);
    }
}
