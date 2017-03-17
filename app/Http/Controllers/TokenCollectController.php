<?php

namespace App\Http\Controllers;

use App\PushToken;
use Illuminate\Http\Request;

class TokenCollectController extends Controller
{
    public function save_token(Request $request)
    {
        if (PushToken::where('token', $request->token)->first() == null) {
            $token = new PushToken();
            $token->token = $request->token;
            $token->save();
        }
        echo "OK";
    }
}
