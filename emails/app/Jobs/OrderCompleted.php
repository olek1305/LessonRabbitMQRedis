<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Message;

class OrderCompleted implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        \Mail::send('influencer.admin', [
            'id' => $this->data['id'],
            'admin_total' => $this->data['admin_total']
        ], function (Message $message) {
            $message->to('admin@admin.com');
            $message->subject('A new order has been completed!');
        });

        \Mail::send('influencer.influencer', [
            'code' => $this->data['code'],
            'influencer_total' => $this->data['influencer_total']
        ], function (Message $message) {
            $message->to($this->data['influencer_email']);
            $message->subject('A new order has been completed!');
        });
    }
}
