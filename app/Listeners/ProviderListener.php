<?php

namespace App\Listeners;

use App\Events\ProviderEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProviderActionNotification;
use Illuminate\Support\Facades\Log;

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
        Log::info('ProviderListener ejecutándose', [
        'provider_id' => $event->provider->id,
        'user_id' => $event->user?->id,
        'action' => $event->action
    ]);

    try {
        $event->user->notify(new ProviderActionNotification($event->provider, $event->action));
        \Log::info('Notificación enviada exitosamente');
    } catch (\Throwable $e) {
        \Log::error('Error al enviar notificación', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }

    }
}
