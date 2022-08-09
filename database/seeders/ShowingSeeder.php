<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Showing;
use App\Models\ShowingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $faker = \Faker\Factory::create();
        $movies = Movie::all();
        $rooms = Room::all();
        $languages = Language::all();
        $showingTypes = ShowingType::all();

        for($i=0; $i<150; $i++){
            $data[$i] = [
                "movie_id" => $movies->random(1)->pluck("id")[0],
                "room_id" => $rooms->random(1)->pluck("id")[0],
                "showing_type_id" => $showingTypes->random(1)->pluck("id")[0],
                "language_id" => $languages->random(1)->pluck("id")[0],
                "begin" => $faker->dateTimeBetween("2022-01-01", "2022-12-31"),
                "price" => rand(50, 100) / 10
            ];
        }

        Showing::insert($data);
    }
}
