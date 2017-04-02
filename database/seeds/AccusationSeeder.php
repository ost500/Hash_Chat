<?php

use Illuminate\Database\Seeder;

class AccusationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Accusation::class, 10)->create();
    }
}
