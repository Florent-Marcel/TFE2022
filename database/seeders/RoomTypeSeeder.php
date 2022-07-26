<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
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
                'type' => "2D",
            ],
            [
                'type' => "3D",
            ],
            [
                'type' => "2D Atmos",
            ]
        ];

        RoomType::insert($data);
    }
}
