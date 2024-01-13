<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RangeRequested implements ShouldBroadcast
{
    // use Dispatchable, InteractsWithSockets, SerializesModels;

    public $start;

    public function __construct($start)
    {
        $this->start = $start;
    }

    public function broadcastOn()
    {
        return new Channel('audio-stream');
    }
}
