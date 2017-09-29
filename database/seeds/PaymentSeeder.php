<?php

use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->truncate();
        DB::table('banks')->insert([
            'bank_name' => 'BCA'
        ]);

        DB::table('banks')->insert([
            'bank_name' => 'Mandiri'
        ]);

        DB::table('banks')->insert([
            'bank_name' => 'BRI'
        ]);


        DB::table('cash_accounts')->truncate();
        DB::table('cash_accounts')->insert([
            'cash_account_name' => 'Front Office Cash',
            'cash_account_desc' => 'Cash Front Office',
            'cash_account_amount' => 0,
            'code' => 'fo'
        ]);

        DB::table('cash_accounts')->insert([
            'cash_account_name' => 'Back Office Cash',
            'cash_account_desc' => 'Cash Back Office',
            'cash_account_amount' => 0,
            'code' => 'bo'
        ]);

        DB::table('cash_accounts')->insert([
            'cash_account_name' => 'Outlet Cash',
            'cash_account_desc' => 'Cash Outlet',
            'cash_account_amount' => 0,
            'code' => 'co'
        ]);

        DB::table('cc_types')->truncate();
        DB::table('cc_types')->insert([
            'cc_type_name' => 'Visa'
        ]);

        DB::table('cc_types')->insert([
            'cc_type_name' => 'Master Card'
        ]);

        DB::table('settlements')->truncate();
        DB::table('settlements')->insert([
            'settlement_name' => 'Cicilan BCA 0%',
            'settlement_bank_id' => 1
        ]);

        DB::table('settlements')->insert([
            'settlement_name' => 'Cicilan Mandiri 0%',
            'settlement_bank_id' => 2
        ]);

    }
}
