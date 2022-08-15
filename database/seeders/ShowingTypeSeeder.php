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
                'type_fr' => "Marathon",
                'type_en' => "Marathon",
                'is_event' => 1,
            ],
            [
                'type_fr' => "Visite du casting",
                'type_en' => "Cast visit",
                'is_event' => 1,
            ],
            [
                'type_fr' => "Classique",
                'type_en' => "Classic",
                'is_event' => 1,
            ],
            [
                'type_fr' => "Avant-première",
                'type_en' => "Preview",
                'is_event' => 1,
            ],
            [
                'type_fr' => "Film",
                'type_en' => "Movie",
                'is_event' => 0,
            ],
        ];

        ShowingType::insert($data);
    }
}
