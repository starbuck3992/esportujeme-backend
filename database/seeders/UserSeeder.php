<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user1',
                'email' => 'user1@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => true
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user2',
                'email' => 'user2@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user3',
                'email' => 'user3@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user4',
                'email' => 'user4@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user5',
                'email' => 'user5@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user6',
                'email' => 'user6@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user7',
                'email' => 'user7@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
            [
                'avatar' => 'images/avatars/default/user.png',
                'nickname' => 'user8',
                'email' => 'user8@esportujeme.cz',
                'password' => Hash::make('esportujeme'),
                'is_admin' => false
            ],
        ]);
    }
}
