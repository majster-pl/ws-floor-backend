<?php

namespace App\Events;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\BookingChangesConfirmation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->event = ['type' => 'new'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
        return new Channel('events');
    }

    public function broadcastAs()
    {
        return 'events-updated';
    }
}
