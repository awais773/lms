<?php

namespace App\Providers;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use App\Events\NewMessageEvent;
use App\Listeners\SendNewMessageNotification;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::channel('chat-channel', function ($user) {
            return true; // Customize the channel authorization logic if needed
        });
    
        Event::listen(NewMessageEvent::class, SendNewMessageNotification::class);
    }
}
