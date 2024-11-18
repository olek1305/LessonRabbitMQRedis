<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCompleted implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
