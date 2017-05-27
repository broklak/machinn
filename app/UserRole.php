<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
        $data = Cache::get('role-'.$role);;
        if(empty($data)){
            return false;
        }

        if(!in_array($submoduleId.'-'.$type, $data)){
            return false;
        }

        return true;
    }
}
