<?php

namespace App\Http\Controllers;

use App\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function get_chat(Request $request)
    {
        $time = $request->time;
        if($request->time == null)
        {
            $time = Carbon::now();
        }

        $chats = Chat::where('created_at', '<', $time)->latest()->limit(5)->get();
        return response()->json($chats);
    }
}
