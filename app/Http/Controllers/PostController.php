<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get_posts(Request $request)
    {
        $posts = Post::latest()->forPage($request->page, 3)->get();
        return response()->json($posts);
    }

    public function each_post($id)
    {
        $posts = Post::with('comments')->with('likes')->findOrFail($id);
        return response()->json($posts);
    }
}
