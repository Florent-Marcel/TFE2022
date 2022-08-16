<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            'token' => 'eyJpdiI6IldTc1ZuaWFlT2R6d1ZmT2daamVkdkE9PSIsInZhbHVlIjoiVXlYeWF1ay9aK2hlcVZzVFFKM3dVdz09IiwibWFjIjoiZTFmZmQ3MmY3OTI1NGNhMDdhNjExMDMwYjdlMDA4NjYzZmI0MDE3NWNmOTk3MTQyMmIyYjNiZmUyYzIxODNiNiIsInRhZyI6IiJ9',
        ]);
    }
}
