<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ProviderEvents;
use App\Listeners\ProviderListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProviderEvents::class => [
            ProviderListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
