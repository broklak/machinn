<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserRole extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_type_id', 'submodule_id', 'type'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $roleId
     * @param $submoduleId
     * @param $type
     * @return bool
     */
    public static function insertToCache ($roleId, $submoduleId, $type){
        $data = Cache::get('role-'.$roleId);
        $roleData = (!empty($data)) ? $data : [];
        if(!in_array($submoduleId.'-'.$type, $roleData)){
            $roleData[] = $submoduleId.'-'.$type;
            Cache::forever('role-'.$roleId, $roleData);
        }
        return true;
    }

    /**
     * @param $roleId
     */
    public static function clearRoleCache ($roleId){
        Cache::forget('role-'.$roleId);
    }

    /**
     * @param $roleId
     * @param $submoduleId
     * @param $type
     * @return bool
     */
    public static function checkAccess($submoduleId, $type, $roleId = null){
        $role = ($roleId == null) ? Auth::user()->employee_type_id : $roleId;
        $data = Cache::get('role-'.$role);
        if(empty($data)){
            return false;
        }

        if(!in_array($submoduleId.'-'.$type, $data)){
            return false;
        }

        return true;
    }

    /**
     * @param $listSubmodule
     * @return bool
     */
    public static function validateMenu ($listSubmodule){
        if(!Auth::user()){
            return false;
        }
        $role = Auth::user()->employee_type_id;
        $submodules = explode(',', $listSubmodule);

        $data = Cache::get('role-'.$role);

        foreach($data as $key => $value){
            $submodule = explode('-', $value);

            if(in_array($submodule[0], $submodules)){
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public static function showMenu (){
        $file = \Illuminate\Support\Facades\File::get("../database/data/Menu.json");
        $data = json_decode($file, true);
        $menu = [];
        foreach($data as $key => $val){
            $menu[$key] = self::validateMenu($val);
        }

        return $menu;
    }
}
