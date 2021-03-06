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
            'name' => 'Foo',
            'email' => 'foo@example.com',
        ]);
        factory(App\User::class, 10)->create();
    }
}
