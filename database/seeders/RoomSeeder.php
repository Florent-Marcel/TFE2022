<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $roomtypes = RoomType::all();
        for($i=0; $i<150; $i++){
            $idType = $roomtypes->random(1)->pluck("id")[0];
            $data[$i] = [
                "room_type_id" => $idType,
                "num_room" => $i,
                "nb_places" => rand(50, 150),
            ];
        }

        Room::insert($data);
    }
}
