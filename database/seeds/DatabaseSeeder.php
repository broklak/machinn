<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(RateTypeSeeder::class);
//         $this->call(MasterMenuSeeder::class);
//         $this->call(ProfileSeeder::class);
//         $this->call(TaxSeeder::class);
//         $this->call(DepartmentSeeder::class);
         $this->call(EmployeeTypeSeeder::class);
    }
}
