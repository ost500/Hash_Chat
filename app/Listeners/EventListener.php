<?php

namespace App\Listeners;

use App\Events\SomeEvent;
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
        Log::info($data->data->name);

        $brain = new BrainSocketAppResponse();


        return $brain->message('receive.message', [
            'name' => $data->data->name,
            'message' => $data->data->message
        ]);
    }
}
