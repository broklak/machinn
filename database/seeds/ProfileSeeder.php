<?php

use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hotel_profile')->truncate();
        DB::table('hotel_profile')->insert([
            'name'  => null,
        ]);
    }
}
