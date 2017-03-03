<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserEditController extends Controller
{
    public function user_edit(Request $request)
    {
//        return $request->all();
//        return Auth::guard('api')->user()->name;

        Validator::make($request->all(), [
            'name' => 'required|max:255',

        ])->validate();


        if (Auth::guard('api')->user()) {
            $edit_user = Auth::guard('api')->user();
            if ($request->name) {
                $edit_user->name = $request->name;
            }
            if ($request->email) {
                if ($edit_user->email != $request->email) {

                    Validator::make($request->all(), [
                        'email' => 'required|email|max:255|unique:users',
                    ])->validate();

                    $edit_user->email = $request->email;
                }

            }
            $edit_user->save();

            return response()->json(
                ["email" => $edit_user->email, "name" => $edit_user->name, "api_token" => $edit_user->api_token, "picture" => $edit_user->picture]);
        } else {
//            return "not loged";
            return response()->json(
                ["email" => $request->email, "name" => $request->name, "api_token" => $request->api_token, "picture" => $request->picture]);
        }
    }

}
