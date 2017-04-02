<?php

namespace App\Http\Controllers;

use App\Accusation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AccusationController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'post_id' => 'required',
        ], [
            'post_id.required' => '에러가 발생했습니다',

        ])->validate();

        $accu = new Accusation();
        if (Auth::guard('api')->user()) {
            $accu->user_id = Auth::guard('api')->user()->id;
        }

        $accu->post_id = $request->post_id;
        $accu->contents = $request->contents;

        $accu->save();

    }
}
