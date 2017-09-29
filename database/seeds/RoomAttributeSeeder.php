<?php

use Illuminate\Database\Seeder;

class RoomAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_attributes')->truncate();
        DB::table('room_attributes')->insert([
        	'room_attribute_name'	=> 'Bath Up',
        ]);

        DB::table('room_attributes')->insert([
            'room_attribute_name'   => 'TV',
        ]);

        DB::table('room_attributes')->insert([
            'room_attribute_name'   => 'Safe Box',
        ]);
    }
}
