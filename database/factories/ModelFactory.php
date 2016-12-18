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
    ];
});


$factory->define(App\HashTag::class, function (Faker\Generator $faker) {

    return [
        'tag' => $faker->word,
       
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



