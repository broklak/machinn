<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRateDateType extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_rate_day_types';

    /**
     * @var array
     */
    protected $fillable = [
        'room_rate_day_type_name', 'room_rate_day_type_list'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_rate_day_type_id';
}
