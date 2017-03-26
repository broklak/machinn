<?php

use Illuminate\Database\Seeder;

class MasterMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();
        $json = File::get("database/data/Modules.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DB::table('modules')->insert([
                'module_id'            => $obj->module_id,
                'module_name'   => $obj->module_name,
            ]);
        }

        DB::table('submodules')->truncate();
        $json = File::get("database/data/Submodules.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DB::table('submodules')->insert([
                'submodule_id'            => $obj->submodule_id,
                'submodule_name'   => $obj->submodule_name,
                'module_id'         => $obj->module_id
            ]);
        }

        DB::table('classes')->truncate();
        $json = File::get("database/data/Classes.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DB::table('classes')->insert([
                'class_id'            => $obj->class_id,
                'class_name'   => $obj->class_name,
                'submodule_id'         => $obj->submodule_id
            ]);
        }
    }
}
