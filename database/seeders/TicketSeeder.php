<?php

namespace Database\Seeders;

use App\Models\Showing;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $showings = Showing::all();
        $faker = \Faker\Factory::create();

        $data = [];
        for($i=0; $i<150; $i++){
            $is_used = rand(0, 1);
            $is_blocked = 0;
            if(rand(0,1)){
                $is_blocked = !$is_used;
            }
            $data[$i] = [
                "user_id" => $users->random(1)->pluck("id")[0],
                "showing_id" => $showings->random(1)->pluck("id")[0],
                "unique_code" => $faker->uuid(),
                "is_used" => $is_used,
                "is_blocked" => $is_blocked,
            ];
        }
        Ticket::insert($data);
    }
}
