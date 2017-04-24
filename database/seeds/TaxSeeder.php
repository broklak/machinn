<?php

use Illuminate\Database\Seeder;


class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->truncate();
        DB::table('taxes')->insert([
            'tax_name'  => 'Government Tax',
            'tax_percentage'  => 10,
            'tax_type'      => 2
        ]);

        DB::table('taxes')->insert([
            'tax_name'  => 'Service',
            'tax_percentage'  => 5,
            'tax_type'      => 2
        ]);

        DB::table('pos_tax')->truncate();
        DB::table('pos_tax')->insert([
            'name'  => 'Government Tax',
            'percentage'  => 11
        ]);

        DB::table('pos_tax')->insert([
            'name'  => 'Service',
            'percentage'  => 10
        ]);
    }
}
