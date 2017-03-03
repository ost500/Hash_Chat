<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show(Request $request, $id)
    {
        $comment = Comment::where('post_id', $id)->forPage($request->page, 5)->get();
        return response()->json($comment);
    }

    public function store(Request $request, $id)
    {
        if (Auth::guard('api')->user()) {

            $like = new Comment();
            $like->user_id = Auth::guard('api')->user()->id;
            $like->post_id = $id;
            $like->message = $id;
            $like->save();

        } else {
            return response("먼저 로그인 하세요", 402);
        }
    }
}
