<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'banks';

    /**
     * @var array
     */
    protected $fillable = [
        'bank_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'bank_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
