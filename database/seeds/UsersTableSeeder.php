<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::forceCreate([
        	'name' => 'Tyler Reed',
        	'email' => 'tylernathanreed@gmail.com',
        	'password' => bcrypt('password'),
        	'blocked_from' => []
        ]);
    }
}
