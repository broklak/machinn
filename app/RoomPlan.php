<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomPlan extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_plans';

    /**
     * @var array
     */
    protected $fillable = [
        'room_plan_name', 'room_plan_additional_cost'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_plan_id';
}
