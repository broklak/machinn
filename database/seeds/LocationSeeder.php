<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();

        DB::table('countries')->insert([
            'country_name'  => 'Indonesia',
        ]);

        DB::table('provinces')->truncate();
        $json = File::get("database/data/Province.json");
        $data = json_decode($json);

        foreach ($data as $key => $obj) {
            DB::table('provinces')->insert([
                'province_name'   => ucwords(strtolower($obj->province_name)),
                'country_id'         => 1
            ]);
        }
    }
}
