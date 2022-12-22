<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            [
                'name' => 'FIFA 23',
                'slug' => 'fifa_23'
            ],
            [
                'name' => 'NHL 23',
                'slug' => 'nhl_23'
            ],
            [
                'name' => 'UFC 4',
                'slug' => 'ufc_4'
            ],
        ]);
    }
}
