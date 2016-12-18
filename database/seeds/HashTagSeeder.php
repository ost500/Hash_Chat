<?php

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
    }
}
