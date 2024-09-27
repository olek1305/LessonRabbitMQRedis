<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use Illuminate\Mail\Message;

class NotifyAdminListener
{
    /**
     * Handle the event.
     */
    public function handle(OrderCompletedEvent $event): void
    {
        $order = $event->order;

        \Mail::send('influencer.admin', ['order' => $order], function (Message $message) {
            $message->to('admin@admin.com');
            $message->subject('A new order has been completed!');
        });
    }
}
