<?php

namespace Database\Seeders;

use App\Models\ShowingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowingTypeSeeder extends Seeder
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
                'type' => "Marathon",
                'is_event' => 1,
            ],
            [
                'type' => "Cast_visit",
                'is_event' => 1,
            ],
            [
                'type' => "Classic",
                'is_event' => 1,
            ],
            [
                'type' => "Preview",
                'is_event' => 1,
            ],
            [
                'type' => "Movie",
                'is_event' => 0,
            ],
        ];

        ShowingType::insert($data);
    }
}
