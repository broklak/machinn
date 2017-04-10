<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyAttribute extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'property_attributes';

    /**
     * @var array
     */
    protected $fillable = [
        'property_attribute_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'property_attribute_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
