<?php

use Illuminate\Database\Seeder;

class RateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_rate_day_types')->truncate();
        DB::table('room_rate_day_types')->insert([
            'room_rate_day_type_name' => 'Weekdays',
            'room_rate_day_type_list' => 'monday,tuesday,wednesday,thursday,sunday',
        ]);
        DB::table('room_rate_day_types')->insert([
                'room_rate_day_type_name' => 'Weekends',
                'room_rate_day_type_list' => 'friday,saturday'
            ]);
    }
}
