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
        $user=App\User::create([
            'name'      => 'Super Admin',
            'email'     => 'super@admin.com',
            'password'  => bcrypt('123'),
        ]);
        $user->assignRole('Admin');
        $users = factory(App\User::class, 7)->create();
        foreach($users as $user){
            $user->assignRole('Client');
        }

    }
}
