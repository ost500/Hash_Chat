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

            if (Like::where('user_id', Auth::guard('api')->user()->id)
                ->where('post_id', $id)->get()->isEmpty()
            ) {
                $like = new Like();
                $like->user_id = Auth::guard('api')->user()->id;
                $like->post_id = $id;
                $like->save();
            } else {
                Like::where('user_id', Auth::guard('api')->user()->id)
                    ->where('post_id', $id)->delete();
            }


        } else {
            return response("먼저 로그인 하세요", 402);
        }
    }
}
