<?php

namespace App\Http\Controllers;

use App\HashTag;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get_posts(Request $request)
    {
//        $posts = Post::latest()->with('users')->withCount('hash_tags')->withCount('likes')->withCount('comments')->forPage($request->page, 3)->get();

        $tag = $request->tag;
        $posts = Post::whereHas('hash_tags', function ($q) use ($tag) {
            $q->where('tag', $tag);
        })
            ->with('users')->withCount('hash_tags')->with('hash_tags')->withCount('likes')->withCount('comments')
            ->forPage($request->page, 3)->get();

        return response()->json($posts);
    }

    public function each_post($id)
    {
        $posts = Post::with('comments.users')->with('likes.users')->with('users')->with('hash_tags')->findOrFail($id);
        return response()->json($posts);
    }

    public function getHashTagPicture(Request $request)
    {
        $tag = $request->tag;


        $picture = HashTag::where('tag', $tag)->first();

        return response()->json($picture);
    }
}
