<?php

namespace App\Http\Controllers;

use App\HashTag;
use Illuminate\Http\Request;

class HashTagController extends Controller
{
    public function hashtag(Request $request)
    {
        $hashtags = HashTag::where('tag', 'like', $request->tag . "%")
            ->orderby('posts_count')->withCount('posts')->get();
        return response()->json($hashtags);
    }
}
