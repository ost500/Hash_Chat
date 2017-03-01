<?php

namespace App\Http\Controllers;

use App\HashTag;
use App\Post;
use App\PostHashTag;
use Illuminate\Http\Request;
use Validator;

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

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'message' => 'required|max:1000',

            'hashtag' => 'required|max:1000',
        ], [
            'message.required' => '내용을 입력하세요',
            'message.max' => '내용이 너무 깁니다',
            'hashtag.required' => '해시태그를 입력하세요',
            'hashtag.max' => '해시태그가 너무 많습니다',
        ])->validate();

        $newPost = new Post();

        $newPost->message = $request->message;
        $newPost->picture = "/image/default.png";

        $newPost->save();


        str_replace(" ", "", $request->hashtag);
        $newHashArray = explode("#", $request->hashtag);

        foreach ($newHashArray as $newHashArrayItem) {


            $hashQuery = HashTag::where('tag', $newHashArrayItem)->get();

            if ($hashQuery->isEmpty()) {
                $newHashTag = new HashTag();
                $newHashTag->tag = $newHashArrayItem;
                $newHashTag->save();

                $hash_id = $newHashTag->id;
            } else {
                $hash_id = $hashQuery->first()->id;
            }

            $newHashTag = new PostHashTag();
            $newHashTag->post_id = $newPost->id;
            $newHashTag->hash_tag_id = $hash_id;

        }

        return "OK";


    }
}
