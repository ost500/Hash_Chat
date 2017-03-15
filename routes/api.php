<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
Route::post('/edit_profile_picture', 'UserEditController@profile_picture');

Route::get('/posts', 'PostController@get_posts');
Route::get('/my_posts', 'PostController@my_posts');
Route::post('/posts', 'PostController@store');
Route::delete('/posts/{id}', 'PostController@destroy');

Route::get('/hash_tag_picture', 'PostController@getHashTagPicture');
Route::get('/each_post/{id}', 'PostController@each_post');
Route::get('/chats', 'ChatController@get_chat');
Route::get('/hashtag', 'HashTagController@hashtag');

Route::post('/like/{id}', 'LikeController@store');

Route::get('/comments/{id}', 'CommentController@show');
Route::post('/comments/{id}', 'CommentController@store');
Route::delete('/comments/{id}', 'CommentController@destroy');

Auth::routes();






