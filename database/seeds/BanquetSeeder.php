<?php

use Illuminate\Database\Seeder;

class BanquetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banquets')->truncate();
        DB::table('banquets')->insert([
            'banquet_name'  => 'Joshua Birthday Party',
            'banquet_start' => '15:00',
            'banquet_end' => '17:00'
        ]);

        DB::table('banquets')->insert([
            'banquet_name'  => 'James and Jenny Wedding Party',
            'banquet_start' => '19:00',
            'banquet_end' => '21:00'
        ]);

        DB::table('banquets')->insert([
            'banquet_name'  => 'PT Kreatif Teknologi Morning Meeting',
            'banquet_start' => '08:00',
            'banquet_end' => '11:00'
        ]);
    }
}
