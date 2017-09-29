<?php

use Illuminate\Database\Seeder;

class BanquetEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banquet_events')->truncate();
        DB::table('banquet_events')->insert([
            'event_name'    => 'Birthday Party'
        ]);

        DB::table('banquet_events')->insert([
            'event_name'    => 'Wedding Party'
        ]);

        DB::table('banquet_events')->insert([
            'event_name'    => 'Corporate Meeting'
        ]);
    }
}
