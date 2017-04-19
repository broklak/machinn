<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'nik', 'ktp', 'birthplace', 'birthdate', 'religion', 'gender', 'address', 'phone', 'department_id', 'employee_status_id', 'employee_type_id', 'join_date', 'npwp', 'bank_name',
        'bank_number', 'bank_account_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getTypeName ($typeId) {
        $type = EmployeeType::find($typeId);

        return (isset($type->employee_type_name)) ? $type->employee_type_name : null;
    }

    public static function getName ($id){
        return self::find($id)->value('username');
    }

    public static function getDepartmentName ($departmentId) {
        $department = Department::withTrashed()->find($departmentId);

        return (isset($department->department_name)) ? $department->department_name : null;
    }

    public static function getStatusName ($statusId) {
        $status = EmployeeStatus::find($statusId);

        return (isset($status->employee_status_name)) ? $status->employee_status_name : null;
    }
}
