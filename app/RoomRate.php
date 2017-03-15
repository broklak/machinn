<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRate extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_rates';

    /**
     * @var array
     */
    protected $fillable = [
        'room_rate_day_type_id', 'room_rate_type_id', 'room_price'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_rate_id';
}
