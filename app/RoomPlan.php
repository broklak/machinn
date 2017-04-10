<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomPlan extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
