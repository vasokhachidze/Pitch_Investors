<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MpesaResponseEvent implements shouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($response)
    {
        $this->response = $response;
        Log::info($this->response);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('mpesa-response');
    }

    public function broadcastAs()
    {
        return 'mpesa-response-event';
    }
}
