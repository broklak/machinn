<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
