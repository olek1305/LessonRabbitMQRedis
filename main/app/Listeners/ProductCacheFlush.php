<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductCacheFlush
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        \Cache::flush('products');
    }
}
