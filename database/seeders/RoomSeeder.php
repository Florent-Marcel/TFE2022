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
            $nbRows = rand(10, 15);
            $maxByRows = rand(10, 30);
            $data[$i] = [
                "room_type_id" => $idType,
                "num_room" => $i,
                "nb_places" => $nbRows*$maxByRows,
                "nb_rows" => $nbRows,
                "max_places_row" => $maxByRows,
                "layout_json" => Room::generateJson($nbRows, $maxByRows),
            ];
        }

        Room::insert($data);
    }
}
