<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
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
}
