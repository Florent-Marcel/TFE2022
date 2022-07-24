<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
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
                'type' => "Family",
            ],
            [
                'type' => "Horror",
            ],
            [
                'type' => "Biography",
            ],
            [
                'type' => "Documentary",
            ],
            [
                'type' => "War",
            ],
            [
                'type' => "History",
            ],
            [
                'type' => "Mystery",
            ],
            [
                'type' => "Comedy",
            ],
            [
                'type' => "Action",
            ],
            [
                'type' => "Adventure",
            ],
            [
                'type' => "Thriller",
            ],
            [
                'type' => "Music",
            ],
            [
                'type' => "Suspense",
            ],
            [
                'type' => "Drama",
            ],
            [
                'type' => "Crime",
            ],
            [
                'type' => "Animation",
            ],
            [
                'type' => "Fantasy",
            ],
            [
                'type' => "Science Fiction",
            ],
            [
                'type' => "Western",
            ],
        ];

        Type::insert($data);
    }
}
