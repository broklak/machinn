<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeShift extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
