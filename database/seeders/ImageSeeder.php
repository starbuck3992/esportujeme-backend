<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
                'original_name' => 'user.png',
                'path' => 'images/avatars/default/user.png',
                'extension' => 'png',
                'size' => 937
            ]
        );
    }
}
