<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function me(Request $request)
    {
        if( isset($request->api_token)){
            echo "OK";
        };if( Auth::guard('api')->user()){
            echo "OK";
        };
        return Auth::guard('api')->user()->id;
    }
}
