<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->truncate();
        DB::table('departments')->insert([
            'department_name'  => 'Front Office',
            'department_status'  => 1,
        ]);

        DB::table('departments')->insert([
            'department_name'  => 'Back Office',
            'department_status'  => 1,
        ]);

        DB::table('departments')->insert([
            'department_name'  => 'House Keeping',
            'department_status'  => 1,
        ]);

        DB::table('departments')->insert([
            'department_name'  => 'Resto',
            'department_status'  => 1,
        ]);
    }
}
