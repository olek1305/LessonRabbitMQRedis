<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AdminAdded implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send('admin.adminAdded', ['email' => $this->email], function ($message) {
            $message->to($this->email)->subject('Admin Added');
        });
    }
}
