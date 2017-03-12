<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'employee_status';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_status_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'employee_status_id';
}
