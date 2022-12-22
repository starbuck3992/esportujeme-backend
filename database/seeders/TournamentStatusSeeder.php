<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentStatusSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournament_statuses')->insert([
            [
                'name' => 'Registrace otevřena'
            ],
            [
                'name' => 'Registrace uzavřena'
            ],
            [
                'name' => 'Probíhá'
            ],
            [
                'name' => 'Uzavřen'
            ],
        ]);
    }
}
