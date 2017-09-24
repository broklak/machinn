<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'username'  => 'admin',
            'name'  => 'Admin',
            'employee_type_id'  => 1,
            'password'  => bcrypt('admin123'),
        ]);
    }
}
