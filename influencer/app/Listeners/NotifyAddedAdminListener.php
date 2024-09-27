<?php

namespace App\Listeners;

use Illuminate\Mail\Message;

class NotifyAddedAdminListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        \Mail::send('admin.adminAdded', [], function (Message $message) use ($user) {
            $message->to($user->email);
            $message->subject('You have been added to the Admin App!');
        });
    }
}
