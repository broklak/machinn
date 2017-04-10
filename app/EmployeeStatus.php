<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeStatus extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
