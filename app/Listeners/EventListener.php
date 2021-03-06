<?php

namespace App\Listeners;

use App\Chat;
use App\Events\SomeEvent;
use App\User;
use BrainSocket\BrainSocket;
use BrainSocket\BrainSocketAppResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventListener
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


//        Log::info($data->data->name);
//        Log::info($data->data->hash_tag."--------");

        $brain = new BrainSocketAppResponse();

//        $new_chat = new Chat();
//        $new_chat->user_id = $data->data->user_id;
//        $new_chat->hash_tag_id = $data->data->hash_tag_id;
//        $new_chat->message = $data->data->message;
//        $new_chat->save();


        return $brain->message( $data->data->hash_tag, [
            'name' => $data->data->name,
            'message' => $data->data->message,
            'api_token' => $data->data->api_token
        ]);
    }
}
