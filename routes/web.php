<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/edit_user', 'UserEditController@user_edit');

Route::get('/home', 'HomeController@index');

Route::get('/token', 'HomeController@token');

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://localhost/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'I36zpsrh34bKnFe9mgpxp3HCPqRRrGVkSRU0xKcP',
            'redirect_uri' => 'http://localhost.com/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::post('/me', 'HomeController@me');



Route::get('/facebook/login', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    session_start();

    // Send an array of permissions to request
    $login_url = $fb->getLoginUrl(['public_profile']);

    // Obviously you'd do this in blade :)
//    echo '<a href="' . $login_url . '">Login with Facebook</a>';
    return redirect()->to($login_url);
});

Route::get('/facebook/callback', function (SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (!$token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        if (!$helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }

    if (!$token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    $fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string)$token);

    // Get basic info on the user from Facebook.
    try {
        $response = $fb->get('/me?fields=picture.type(large),name,email');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    $facebook_user = $response->getGraphUser();


//    print_r($facebook_user);

    $user = new User();
    $user->name = $facebook_user->getName();
    $user->email = $facebook_user->getEmail();
    $user->picture = $facebook_user->getPicture()->getUrl();
    $user->password = "facebook_account";
    $user->api_token = str_random(60);

    $user->save();

    // Create the user if it does not exist or update the existing entry.
    // This will only work if you've added the SyncableGraphNodeTrait to your User model.
//    $user = App\User::createOrUpdateGraphNode($facebook_user);

    // Log the user into Laravel
//    Auth::login($user);
//    print_r($user);
//    print_r(Auth::user());


    return response($user);
});
