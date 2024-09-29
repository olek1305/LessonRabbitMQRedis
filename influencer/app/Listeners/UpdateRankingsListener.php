<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsListener
{
    /**
     * Handle the event.
     */
    public function handle(OrderCompletedEvent $event): void
    {
        $order = $event->order;

        $revenue = $order->influencer_total;

        $user = User::find($order->user_id);

        Redis::zincrby('rankings', $revenue, $user->full_name);
    }
}
