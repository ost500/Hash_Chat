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

Route::post('/edit_user', 'Auth\UserEditController@user_edit');

Auth::routes();