<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
    /**
     * @var string
     */
    protected $table = 'employee_shifts';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_shift_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'employee_shift_id';
}
