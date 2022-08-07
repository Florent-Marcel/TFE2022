<?php

namespace Database\Seeders;

use App\Models\Personality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $data = [];
        for($i=0; $i<150; $i++){
            $data[$i] = [
                'tmdb_id' => $i,
                'name' => $faker->firstName()." ".$faker->lastName(),
            ];
        }

        Personality::insert($data);
    }
}
