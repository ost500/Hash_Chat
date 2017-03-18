<?php

namespace App\Http\Controllers;

use App\HashTag;
use App\Like;
use App\Post;
use App\PostHashTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->with('users')->withCount('hash_tags')->with('hash_tags')->withCount('likes')->withCount('comments')->latest()
            ->forPage($request->page, 3)->get();

        return response()->json($posts);
    }

    public function get_best_posts(Request $request)
    {
//        $posts = Post::latest()->with('users')->withCount('hash_tags')->withCount('likes')->withCount('comments')->forPage($request->page, 3)->get();

        $date = new Carbon();
        $date = $date->subDays(7);

        $tag = $request->tag;
        $posts = Post::whereHas('hash_tags', function ($q) use ($tag) {
            $q->where('tag', $tag);
        })->where('created_at', '>', $date->toDateTimeString())
            ->with('users')->withCount('hash_tags')->with('hash_tags')->withCount('likes')->withCount('comments')
            ->orderBy('likes_count', 'desc')->orderBy('comments_count', 'desc')
            ->get();

        return response()->json($posts);
    }

    public function get_monthlybest_posts(Request $request)
    {
//        $posts = Post::latest()->with('users')->withCount('hash_tags')->withCount('likes')->withCount('comments')->forPage($request->page, 3)->get();

        $date = new Carbon();
        $date = $date->subMonth(1);

        $tag = $request->tag;
        $posts = Post::whereHas('hash_tags', function ($q) use ($tag) {
            $q->where('tag', $tag);
        })->where('created_at', '>', $date->toDateTimeString())
            ->with('users')->withCount('hash_tags')->with('hash_tags')->withCount('likes')->withCount('comments')
            ->orderBy('likes_count', 'desc')->orderBy('comments_count', 'desc')
            ->get();

        return response()->json($posts);
    }

    public function each_post($id)
    {
        $like = ['like' => false];
        if (Auth::guard('api')->user()) {
            if (Like::where('user_id', Auth::guard('api')->user()->id)->where('post_id', $id)->get()->isEmpty()) {
                $like['like'] = false;
            } else {
                $like['like'] = true;
            }

        }

        $posts = Post::with('comments.users')->with('likes.users')->with('users')->with('hash_tags')->findOrFail($id);
        return response()->json([$posts, $like]);
    }

    public function my_posts(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $my_post = Post::where('user_id', Auth::guard('api')->user()->id)
                ->with('users')->withCount('hash_tags')
                ->with('hash_tags')->withCount('likes')
                ->withCount('comments')->latest()
                ->forPage($request->page, 3)->get();
        } else {
            $my_post = Post::where('api_token', $request->api_token)
                ->with('users')->withCount('hash_tags')
                ->with('hash_tags')->withCount('likes')
                ->withCount('comments')->latest()
                ->forPage($request->page, 3)->get();

            return response()->json($my_post);
        }


        return response()->json($my_post);
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

        if (Auth::guard('api')->user()) {
            $user_id = Auth::guard('api')->user()->id;
        } else {
            $user_id = 2;
        }


        $newPost = new Post();

        $newPost->message = $request->message;
        $newPost->picture = "/image/default.png";
        $newPost->user_id = $user_id;
        $newPost->api_token = $request->api_token;

        $newPost->save();

        if ($request->hasFile('picture')) {
            // pictureFile = file
            $pictureFile = $request->file('picture');
            // name
            $filename = $pictureFile->getClientOriginalName();
            // path
            $destinationPath = 'picture/';
            // save the name with path
            $newPost->picture = $destinationPath . $newPost->id . '_' . $filename;
            // upload
            $pictureFile->move($destinationPath, $newPost->picture);
            // image compress
            $source_img = $newPost->picture;
            $destination_img = $newPost->picture;
            $this->compress($source_img, $destination_img, 30);
        }
        $newPost->save();

        str_replace(" ", "", $request->hashtag);
        $newHashArray = explode("#", $request->hashtag);

        if (in_array("", $newHashArray)) {
            $newHashArray[] = "";
        }

        $newHashArray = array_unique($newHashArray, SORT_REGULAR);

        foreach ($newHashArray as $newHashArrayItem) {


            $hashQuery = HashTag::where('tag', $newHashArrayItem)->get();

            if ($hashQuery->isEmpty()) {
                $newHashTag = new HashTag();
                $newHashTag->tag = $newHashArrayItem;
                $newHashTag->picture = "/image/default.png";
                $newHashTag->save();

                $hash_id = $newHashTag->id;
            } else {
                $hash_id = $hashQuery->first()->id;
            }

            $newPostHashTag = new PostHashTag();
            $newPostHashTag->post_id = $newPost->id;
            $newPostHashTag->hash_tag_id = $hash_id;
            $newPostHashTag->save();


        }


        return response()->json($newPost);


    }


    public function destroy(Request $request, $id)
    {
        $post = Post::findorfail($id);

        if ((Auth::guard('api')->check()
                && $post->user_id == Auth::guard('api')->user()->id)
            || $post->api_token == $request->api_token
        ) {

            $post->delete();


        } else {
            return response("본인의 게시물만 삭제할 수 있습니다", 402);
        }

    }


    function compress($source, $destination, $quality)
    {

        $info = getimagesize($source);
        $image = "";

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

}
