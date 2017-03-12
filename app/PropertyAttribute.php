<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAttribute extends Model
{
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
}
