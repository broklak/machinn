<?php

use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_types')->truncate();
        DB::table('employee_types')->insert([
            'employee_type_name'  => 'Super Admin',
        ]);
    }
}
