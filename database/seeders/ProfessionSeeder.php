<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'profession' => "Actor",
            ],
            [
                'profession' => "Director",
            ],
            [
                'profession' => "Composer",
            ],
        ];

        Profession::insert($data);
    }
}
