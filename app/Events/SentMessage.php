<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SentMessage implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userid;

    public $message;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message) {
        $this->userid  = $message->userid;
        $this->message = $message->message;
        $this->data    = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return ['sent-message'];
    }
}
