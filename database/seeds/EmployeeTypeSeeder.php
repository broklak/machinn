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
            'employee_type_name'  => 'Admin',
        ]);
        DB::table('employee_types')->insert([
            'employee_type_name'  => 'Front Office',
        ]);
        DB::table('employee_types')->insert([
            'employee_type_name'  => 'Back Office',
        ]);
        DB::table('employee_types')->insert([
            'employee_type_name'  => 'House Keeping',
        ]);
        DB::table('employee_types')->insert([
            'employee_type_name'  => 'POS Resto',
        ]);

        DB::table('employee_shifts')->truncate();
        DB::table('employee_shifts')->insert([
            'employee_shift_name'  => 'Pagi',
        ]);

        DB::table('employee_shifts')->insert([
            'employee_shift_name'  => 'Siang',
        ]);

        DB::table('employee_shifts')->insert([
            'employee_shift_name'  => 'Malam',
        ]);

        DB::table('employee_status')->truncate();
        DB::table('employee_status')->insert([
            'employee_status_name'  => 'Permanent',
        ]);

        DB::table('employee_status')->insert([
            'employee_status_name'  => 'Contract',
        ]);

    }
}
