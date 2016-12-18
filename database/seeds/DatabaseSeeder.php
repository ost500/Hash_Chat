<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        App\Chat::truncate();
//        App\HashTag::truncate();

        

        $this->call(UserSeeder::class);
        $this->call(HashTagSeeder::class);
        $this->call(ChatSeeder::class);
    }
}
