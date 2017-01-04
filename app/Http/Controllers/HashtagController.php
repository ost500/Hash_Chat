<?php

namespace App\Http\Controllers;

use App\HashTag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function tag_picture(Request $request)
    {
        $tag = HashTag::where('tag', $request->tag)->first()->picture;
        return response()->json($tag);
    }
}
