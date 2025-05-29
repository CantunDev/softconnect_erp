<?php

namespace App\Events;

use App\Models\Sfrt\Provider;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProviderEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $provider;
    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct(Provider $provider, string $action)
    {
        $this->provider = $provider;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
