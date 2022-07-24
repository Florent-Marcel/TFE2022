<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
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
                'language' => "FR",
            ],
            [
                'language' => "VO",
            ],
            [
                'language' => "VOSTFR",
            ],
            [
                'language' => "NL",
            ],
            [
                'language' => "VOSTNL",
            ],
            [
                'language' => "VOSTFRNL",
            ],
            [
                'language' => "VOSTEN",
            ],
        ];

        Language::insert($data);
    }
}
