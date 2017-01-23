<?php

use App\HashTag;
use Illuminate\Database\Seeder;

class HashTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        factory(App\HashTag::class, 10)->create();
        $newhash = new HashTag();
        $newhash->tag = "프리미디어";
        $newhash->save();
        $newhash = new HashTag();
        $newhash->tag = "수원대학교";
        $newhash->save();
        $newhash = new HashTag();
        $newhash->tag = "우리회사";
        $newhash->save();
        $newhash = new HashTag();
        $newhash->tag = "컴퓨터학과";
        $newhash->save();
    }
}
