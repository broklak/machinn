<?php

use Illuminate\Database\Seeder;

class PropertyFloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_floors')->truncate();

        DB::table('property_floors')->insert([
            'property_floor_name'   => 'Ground'
        ]);

        DB::table('property_floors')->insert([
            'property_floor_name'   => '1'
        ]);

        DB::table('property_floors')->insert([
            'property_floor_name'   => '2'
        ]);

        DB::table('property_floors')->insert([
            'property_floor_name'   => '3'
        ]);
    }
}
