<?php

use Illuminate\Database\Seeder;

class ExtrachargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extracharge_groups')->truncate();
        DB::table('extracharge_groups')->insert([
            'extracharge_group_name'    => 'Room'
        ]);

        DB::table('extracharge_groups')->insert([
            'extracharge_group_name'    => 'Rent'
        ]);

        DB::table('extracharges')->truncate();
        DB::table('extracharges')->insert([
            'extracharge_name'    => 'Extra Bed',
            'extracharge_group_id'    => 1,
            'extracharge_price'    => 150000
        ]);

        DB::table('extracharges')->insert([
            'extracharge_name'    => 'Sewa Sepeda',
            'extracharge_group_id'    => 2,
            'extracharge_price'    => 100000
        ]);

    }
}
