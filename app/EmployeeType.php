<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    /**
     * @var string
     */
    protected $table = 'employee_types';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_type_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'employee_type_id';
}
