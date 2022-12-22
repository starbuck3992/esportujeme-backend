<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ImageSeeder::class,
            UserSeeder::class,
            PlatformSeeder::class,
            GameSeeder::class,
            TournamentTypeSeeder::class,
            TournamentStatusSeeder::class,
            CurrencySeeder::class,
        ]);
    }
}
