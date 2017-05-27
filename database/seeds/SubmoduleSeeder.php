<?php

use Illuminate\Database\Seeder;

class SubmoduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submodules')->truncate();
        $json = File::get("database/data/Submodules.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DB::table('submodules')->insert([
                'submodule_name'   => $obj->submodule_name,
                'module_id'         => $obj->module_id
            ]);
        }
    }
}
