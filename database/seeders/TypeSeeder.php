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
                'tmdb_id' => 1,
                'type' => "Family",
            ],
            [
                'tmdb_id' => 2,
                'type' => "Horror",
            ],
            [
                'tmdb_id' => 3,
                'type' => "Biography",
            ],
            [
                'tmdb_id' => 4,
                'type' => "Documentary",
            ],
            [
                'tmdb_id' => 5,
                'type' => "War",
            ],
            [
                'tmdb_id' => 6,
                'type' => "History",
            ],
            [
                'tmdb_id' => 7,
                'type' => "Mystery",
            ],
            [
                'tmdb_id' => 8,
                'type' => "Comedy",
            ],
            [
                'tmdb_id' => 9,
                'type' => "Action",
            ],
            [
                'type' => "Adventure",
            ],
            [
                'tmdb_id' => 10,
                'type' => "Thriller",
            ],
            [
                'tmdb_id' => 11,
                'type' => "Music",
            ],
            [
                'tmdb_id' => 12,
                'type' => "Suspense",
            ],
            [
                'tmdb_id' => 13,
                'type' => "Drama",
            ],
            [
                'tmdb_id' => 14,
                'type' => "Crime",
            ],
            [
                'tmdb_id' => 15,
                'type' => "Animation",
            ],
            [
                'tmdb_id' => 16,
                'type' => "Fantasy",
            ],
            [
                'tmdb_id' => 17,
                'type' => "Science Fiction",
            ],
            [
                'tmdb_id' => 18,
                'type' => "Western",
            ],
        ];

        Type::insert($data);
    }
}
