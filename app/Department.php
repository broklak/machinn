<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'departments';

    /**
     * @var array
     */
    protected $fillable = [
        'department_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'department_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
