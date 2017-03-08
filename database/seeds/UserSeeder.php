<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        factory(App\User::class)->create([
            'id' => 2,
            'name' => '익명',
            'email' => 'Anonymouse@osteng.com',
        ]);
        factory(App\User::class, 10)->create();
    }
}
