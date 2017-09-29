<?php

use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_types')->truncate();
        DB::table('room_types')->insert([
        	'room_type_name'	=> 'Superior Twin',
        	'room_type_max_adult' => 2,
        	'room_type_attributes'	=> '',
        	'room_type_max_child' => 1,
        	'room_type_banquet' => 0,
        	'room_type_status' => 1,
        ]);

        DB::table('room_types')->insert([
        	'room_type_name'	=> 'Superior Double',
        	'room_type_max_adult' => 2,
        	'room_type_attributes'	=> '',
        	'room_type_max_child' => 1,
        	'room_type_banquet' => 0,
        	'room_type_status' => 1,
        ]);
    }
}
