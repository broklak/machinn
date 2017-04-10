<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyFloor extends Model
{
    /**
     * @var string
     */
    protected $table = 'property_floors';

    /**
     * @var array
     */
    protected $fillable = [
        'property_floor_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'property_floor_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
