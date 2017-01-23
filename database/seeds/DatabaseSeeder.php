<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUp();

        $this->runDevSeeder();

        $this->tearDown();
    }

    private function setUp()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    private function tearDown()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function runDevSeeder()
    {
//        App\Chat::truncate();
//        App\HashTag::truncate();


        $this->call(UserSeeder::class);
        $this->call(HashTagSeeder::class);
        $this->call(ChatSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(PostHashTagSeeder::class);
    }
}
