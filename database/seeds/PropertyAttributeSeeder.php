<?php

use Illuminate\Database\Seeder;

class PropertyAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_attributes')->truncate();
        DB::table('property_attributes')->insert([

        ]);

        DB::table('property_attributes')->insert([
        	'property_attribute_name'	=> 'Swimming Pool',
        ]);

        DB::table('property_attributes')->insert([
            'property_attribute_name'   => 'Concierge',
        ]);
    }
}
