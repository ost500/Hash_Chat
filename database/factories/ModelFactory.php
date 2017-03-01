<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
    ];
});


$factory->define(App\HashTag::class, function (Faker\Generator $faker) {
    
    return [
        'tag' => $faker->word,
        'picture' => '/image/default.png'
       
    ];
});


$factory->define(App\Chat::class, function (Faker\Generator $faker) {
    $userIds = App\User::pluck('id')->toArray();
    $hash_tagIds = App\HashTag::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userIds),
        'hash_tag_id' => $faker->randomElement($hash_tagIds),
        'message' => $faker->text(200)

    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    $userIds = App\User::pluck('id')->toArray();
    $hash_tagIds = App\HashTag::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userIds),
        
        'message' => $faker->text(200),
        'picture' => '/image/default.png'
    ];
});



$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $userIds = App\User::pluck('id')->toArray();
    $postIds = App\Post::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userIds),
        'post_id' => $faker->randomElement($postIds),
        'message' => $faker->text(200),
    ];
});



$factory->define(App\Like::class, function (Faker\Generator $faker) {
    $userIds = App\User::pluck('id')->toArray();
    $postIds = App\Post::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userIds),
        'post_id' => $faker->randomElement($postIds),
    ];
});





$factory->define(App\PostHashTag::class, function (Faker\Generator $faker) {
    $hashtagIds = App\HashTag::pluck('id')->toArray();
    $postIds = App\Post::pluck('id')->toArray();
    return [
        'hash_tag_id' => $faker->randomElement($hashtagIds),
        'post_id' => $faker->randomElement($postIds),
    ];
});



