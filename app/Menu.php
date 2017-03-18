<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    private $table_module = 'modules';

    private $table_submodule = 'submodules';

    private $table_class = 'classes';


    public function generateMenu() {
        $module = DB::table($this->table_module)->get();
        $menu = array();

        foreach($module as $keyModule => $valModule){
            $menu[$valModule->module_id]['module_name'] = $valModule->module_name;
            $subModule = DB::table($this->table_submodule)->where('module_id', $valModule->module_id)->get();
            foreach($subModule as $keySubmodule => $valSubmodule) {
                $menu[$valModule->module_id]['submodule'][$valSubmodule->submodule_id]['submodule_name'] = $valSubmodule->submodule_name;
                $class = DB::table($this->table_class)->where('submodule_id', $valSubmodule->submodule_id)->get();
                foreach($class as $keyClasses => $valClasses) {
                    $menu[$valModule->module_id]['submodule'][$valSubmodule->submodule_id]['class'][$valClasses->class_id]['class_name'] = $valClasses->class_name;
                }
            }
        }
        Cache::forever('menu', $menu);

        return $menu;
    }
}
