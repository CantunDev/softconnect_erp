<?php

namespace App\Listeners;

use App\Events\ProviderEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProviderActionNotification;

class ProviderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProviderEvents $event): void
    {
        $user = Auth::user();

        // $user->notify(new ProviderActionNotification($event->provider, $event->action));
        $event->user->notify(new ProviderActionNotification($event->provider, $event->action));

    }
}
