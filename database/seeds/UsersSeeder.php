<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name'      => 'Super Admin',
            'email'     => 'super@admin.com',
            'password'     => bcrypt('123'),
        ]);

        factory(App\User::class, 7)->create();
    }
}
