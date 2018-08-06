<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'name'          => 'Henrique Domingos',
            'email'         => 'domingos.dev@gmail.com',
            'password'      => Hash::make('12345'),
            'user_group_id' => 1
        ]);

        // create 10 users using the user factory
        factory(App\User::class, 10)->create();
    }
}