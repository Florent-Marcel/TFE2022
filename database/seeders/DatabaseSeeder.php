<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            AdminSeeder::class,
            TmdbSeeder::class,
            PaypalSeeder::class,
            MovieSeeder::class,
            UserSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            LanguageSeeder::class,
            ShowingTypeSeeder::class,
            ShowingSeeder::class,
            TicketSeeder::class,
        ]);

    }
}
