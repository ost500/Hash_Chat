<?php

use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $users = App\User::get();
        

        $users->each(function ($user) {
            $user->chats()->save(factory(App\Chat::class)->make());


            $user->chats()->save(factory(App\Chat::class)->make());
        });


    }
}
