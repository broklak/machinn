<?php

use Illuminate\Database\Seeder;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partner_groups')->truncate();

        DB::table('partner_groups')->insert([
            'partner_group_name'    =>  "Online Travel Agent"
        ]);

        DB::table('partners')->truncate();
        DB::table('partners')->insert([
            'partner_name'    =>  "Traveloka",
            'partner_group_id' => 1,
            'discount_weekend' => 0,
            'discount_weekday' => 0,
            'discount_special' => 0,
        ]);

        DB::table('partners')->insert([
            'partner_name'    =>  "Agoda",
            'partner_group_id' => 1,
            'discount_weekend' => 0,
            'discount_weekday' => 0,
            'discount_special' => 0,
        ]);

        DB::table('contact_groups')->truncate();

        DB::table('contact_groups')->insert([
            'contact_group_name'    =>  "Catering"
        ]);

        DB::table('contacts')->truncate();
        DB::table('contacts')->insert([
            'contact_name'    =>  "Catering A",
            'contact_group_id' => 1,
            'contact_phone' => '0821234594839'
        ]);

        DB::table('contacts')->insert([
            'contact_name'    =>  "Catering B",
            'contact_group_id' => 1,
            'contact_phone' => '0811234566'
        ]);


    }
}
