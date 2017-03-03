<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($id)
    {
        if (Auth::guard('api')->user()) {
            $like = new Like();
            $like->user_id = Auth::guard('api')->user()->id;
            $like->post_id = $id;
            $like->save();
        } else {
            return response("먼저 로그인 하세요", 402);
        }
    }
}
