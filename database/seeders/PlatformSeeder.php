<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('platforms')->insert([
            [
                'name' => 'Playstation 4',
                'slug' => 'playstation_4'
            ],
            [
                'name' => 'Playstation 5',
                'slug' => 'playstation_5'
            ],
            [
                'name' => 'Xbox Series X',
                'slug' => 'xbox_series_x'
            ],
        ]);
    }
}
