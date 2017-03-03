<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return json_encode(Auth::user());
//    return json_encode($request->user());
})->middleware('auth:api');

Route::post('/me', 'HomeController@me');

Route::post('/edit_user', 'UserEditController@user_edit');

Route::get('/posts', 'PostController@get_posts');
Route::post('/posts', 'PostController@store');
Route::get('/hash_tag_picture', 'PostController@getHashTagPicture');
Route::get('/each_post/{id}', 'PostController@each_post');
Route::get('/chats', 'ChatController@get_chat');
Route::get('/hashtag', 'HashTagController@hashtag');

Route::post('/like/{id}', 'LikeController@store');

Route::get('/comments/{id}', 'CommentController@show');

Auth::routes();