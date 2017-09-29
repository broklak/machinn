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
        $this->call(RateTypeSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(EmployeeTypeSeeder::class);
        $this->call(SubmoduleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoomAttributeSeeder::class);
        $this->call(PropertyFloorSeeder::class);
        $this->call(RoomPlanSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(RoomRatesSeeder::class);
        $this->call(RoomNumberSeeder::class);
        $this->call(BanquetSeeder::class);
        $this->call(RoomNumberSeeder::class);
        $this->call(BanquetSeeder::class);
        $this->call(BanquetEventSeeder::class);
        $this->call(PropertyAttributeSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(BusinessPartnerSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(ExtrachargeSeeder::class);
        $this->call(CostIncomeSeeder::class);
    }
}
