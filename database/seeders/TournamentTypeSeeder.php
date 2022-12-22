<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentTypeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournament_types')->insert([
            [
                'name' => 'Vyřazovací'
            ],
            [
                'name' => 'Každý s každým'
            ],
            [
                'name' => 'Švýcarský'
            ],
        ]);
    }
}
