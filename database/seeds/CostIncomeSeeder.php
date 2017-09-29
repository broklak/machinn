<?php

use Illuminate\Database\Seeder;

class CostIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('costs')->truncate();
        DB::table('costs')->insert([
            'cost_name'     => 'Tagihan Listrik',
            'cost_date'     => date('Y-m-d'),
            'cost_amount'   => 2000000
        ]);

        DB::table('costs')->insert([
            'cost_name'     => 'Tagihan Pajak Bangunan',
            'cost_date'     => date('Y-m-d'),
            'cost_amount'   => 2400000
        ]);

        DB::table('incomes')->truncate();
        DB::table('incomes')->insert([
            'income_name'     => 'Penyewaan Sepeda',
            'income_date'     => date('Y-m-d'),
            'income_amount'   => 2000000
        ]);

        DB::table('incomes')->insert([
            'income_name'     => 'Penjualan Merchandise',
            'income_date'     => date('Y-m-d'),
            'income_amount'   => 2400000
        ]);
    }
}
