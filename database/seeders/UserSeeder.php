<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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

        for($i=0; $i<150; $i++){
            $name = $faker->firstName();
            $data[$i] = [
                "name" => $name,
                "email" => $faker->safeEmail(),
                "password" => Str::random(200),
                "firstname" => $name,
                "lastname" => $faker->lastName(),
                "is_admin" => 0,
            ];
        }

        $data[150] = [
            "name" => "Florent",
            "email" => "flo.marcel@hotmail.com",
            "password" => '$2y$10$phyZqyYk27l8hbOtl9HxH.SmbwuEP4y3O4nrdULIxWv64jhoKu4ry',
            "firstname" => "Florent",
            "lastname" => "Marcel",
            "is_admin" => 1,
        ];

        User::insert($data);
    }
}
