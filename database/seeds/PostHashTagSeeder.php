<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostHashTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::get();
        $posts->each(function ($post) {
            $post->hash_tags()->save(factory(\App\PostHashTag::class)->make());
        });
    }
}
