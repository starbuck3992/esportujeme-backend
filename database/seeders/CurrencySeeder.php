<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'code' => 'CZK'
            ],
            [
                'code' => 'EUR'
            ]
        ]);
    }
}
