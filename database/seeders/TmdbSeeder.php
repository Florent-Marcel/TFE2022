<?php

namespace Database\Seeders;

use App\Models\Tmdb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tmdb::insert([
            'key' => 'eyJpdiI6InJESy9PYWFCN2lLRXUrOTlGdlRMSFE9PSIsInZhbHVlIjoiTzczYzM1RU81bkVXS2huaXBTM2RKdHZlSVc1TnJMTCt4eDdtYWVPOTRobmxBMnBoTVJ5TWlVeHJ0djBYOU5NdSIsIm1hYyI6IjFhMDA5OWRlYzAyMzkxMzhjNDI4ZDE5MTRlMmNkMzIzYjZhZDM3MTdiOWFiNWVlZTBhMjEyMGQ3Yjk3ZmE5OTAiLCJ0YWciOiIifQ==',
            'base_url' => 'https://api.themoviedb.org/3',
            'base_url_img' => 'https://image.tmdb.org/t/p/w300'
        ]);
    }
}
