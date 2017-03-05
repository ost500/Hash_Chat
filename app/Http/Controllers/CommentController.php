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
        $comment = Comment::where('post_id', $id)->with('users')->latest()->forPage($request->page, 5)->get();
        return response()->json($comment);
    }

    public function store(Request $request, $id)
    {
        if (Auth::guard('api')->user()) {

            $like = new Comment();
            $like->user_id = Auth::guard('api')->user()->id;
            $like->post_id = $id;
            $like->message = $request->data;
            $like->save();

        } else {
            return response("먼저 로그인 하세요", 402);
        }
    }

    public function destroy($id)
    {
        $comment = Comment::findorfail($id);
        if (Auth::guard('api')->user()->check()
            && $comment->user_id == Auth::guard('api')->user()->id) {
            $comment->delete();
        } else {
            return response("본인의 댓글만 삭제할 수 있습니다", 402);
        }
    }
}
