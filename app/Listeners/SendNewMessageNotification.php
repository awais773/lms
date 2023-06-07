<?php

namespace App\Listeners;

use App\Events\NewMessageEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewMessageNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(NewMessageEvent $event)
    {
        // Handle the event logic, e.g., send notifications, update UI, etc.
    }
}
