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
        DB::table('user_roles')->truncate();
        $json = File::get("database/data/Submodules.json");
        $data = json_decode($json);
        foreach ($data as $key => $obj) {
            $insert = DB::table('submodules')->insert([
                'submodule_name'   => $obj->submodule_name,
                'module_id'         => $obj->module_id
            ]);

            DB::table('user_roles')->insert([
                'employee_type_id'   => 1,
                'submodule_id'         => $key + 1,
                'type'              => 'create'
            ]);

            DB::table('user_roles')->insert([
                'employee_type_id'   => 1,
                'submodule_id'         => $key + 1,
                'type'              => 'update'
            ]);

            DB::table('user_roles')->insert([
                'employee_type_id'   => 1,
                'submodule_id'         => $key + 1,
                'type'              => 'read'
            ]);

            DB::table('user_roles')->insert([
                'employee_type_id'   => 1,
                'submodule_id'         => $key + 1,
                'type'              => 'delete'
            ]);
        }
    }
}
