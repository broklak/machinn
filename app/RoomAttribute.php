<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomAttribute extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_attributes';

    /**
     * @var array
     */
    protected $fillable = [
        'room_attribute_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_attribute_id';
}
