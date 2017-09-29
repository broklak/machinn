<?php

use Illuminate\Database\Seeder;

class RoomRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_rates')->truncate();
        DB::table('room_rates')->insert([
            'room_rate_day_type_id'     => 1,
            'room_rate_type_id'         => 1,
            'room_price'                => 300000
        ]);

        DB::table('room_rates')->insert([
            'room_rate_day_type_id'     => 2,
            'room_rate_type_id'         => 1,
            'room_price'                => 400000
        ]);

        DB::table('room_rates')->insert([
            'room_rate_day_type_id'     => 1,
            'room_rate_type_id'         => 2,
            'room_price'                => 350000
        ]);

        DB::table('room_rates')->insert([
            'room_rate_day_type_id'     => 2,
            'room_rate_type_id'         => 2,
            'room_price'                => 450000
        ]);
    }
}
