<?php

use Illuminate\Database\Seeder;

class RoomNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_numbers')->truncate();
        DB::table('room_numbers')->insert([
            'room_number_code'      => '101',
            'room_type_id'      => 1,
            'room_floor_id'      => 2,
        ]);

        DB::table('room_numbers')->insert([
            'room_number_code'      => '102',
            'room_type_id'      => 1,
            'room_floor_id'      => 2,
        ]);

        DB::table('room_numbers')->insert([
            'room_number_code'      => '201',
            'room_type_id'      => 2,
            'room_floor_id'      => 3,
        ]);

        DB::table('room_numbers')->insert([
            'room_number_code'      => '202',
            'room_type_id'      => 2,
            'room_floor_id'      => 3,
        ]);

        DB::table('room_numbers')->insert([
            'room_number_code'      => '301',
            'room_type_id'      => 2,
            'room_floor_id'      => 4,
        ]);
    }
}
