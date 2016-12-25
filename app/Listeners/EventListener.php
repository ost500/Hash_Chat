<?php

namespace App\Listeners;

use App\Chat;
use App\Events\SomeEvent;
use BrainSocket\BrainSocket;
use BrainSocket\BrainSocketAppResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent $event

     */
    public function handle($data)
    {

        $brain = new BrainSocketAppResponse();
//
//        $new_chat = new Chat();
//        $new_chat->user_id = $data->data->user_id;
//        $new_chat->hash_tag_id = $data->data->hash_tag_id;
//        $new_chat->message = $data->data->message;
//        $new_chat->save();


        return $brain->message($data->data->hash_tag_id, [
            'name' => $data->data->user_id,
            'message' => $data->data->message
        ]);
    }
}
