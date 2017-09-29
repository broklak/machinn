<?php

use Illuminate\Database\Seeder;

class RoomPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_plans')->truncate();
        DB::table('room_plans')->insert([
            'room_plan_name'    => "Room only",
            'room_plan_additional_cost' => 0,
        ]);

        DB::table('room_plans')->insert([
            'room_plan_name'    => "Room with breakfast",
            'room_plan_additional_cost' => 250000,
        ]);
    }
}
