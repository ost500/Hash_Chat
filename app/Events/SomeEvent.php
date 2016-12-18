<?php

namespace App\Events;

use BrainSocket\BrainSocket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class SomeEvent
{
    use InteractsWithSockets, SerializesModels;
    public $text;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn($data)
    {
        return BrainSocket::message('receive.message', [
            'name' => $data->data->name,
            'message' => $data->data->message
        ]);

//        Log::info("Event working!!!");
//        return ['test-channel'];
//        return new PrivateChannel('channel-name');
    }


}
