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
            $email = "";
            do{
                $doublon = false;
                $email = $faker->safeEmail();
                foreach($data as $user){
                    $doublon = $doublon || ($user['email'] == $email);
                }
            } while($doublon === true);
            $data[$i] = [
                "email" => $email,
                "password" => Str::random(200),
                "firstname" => $name,
                "lastname" => $faker->lastName(),
                "is_admin" => 0,
            ];
        }

        $data[150] = [
            "email" => "flo.marcel@hotmail.com",
            "password" => '$2y$10$ySRCCf11ruobj9fxnqJnsOzkRd/FJ6F/lRTI2bOJNcdSAq3d0KkCu',
            "firstname" => "Florent",
            "lastname" => "Marcel",
            "is_admin" => 1,
        ];

        $data[151] = [
            "email" => "test@testICC.be",
            "password" => '$2y$10$AdiQYc7ZX0EzLMpM1jA0aO9lZUYe0yPCbn6UQ32p4S971C4j9.NGi',
            "firstname" => "Test",
            "lastname" => "Test",
            "is_admin" => 0,
        ];

        User::insert($data);
    }
}
