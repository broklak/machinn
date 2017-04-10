<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtrachargeGroup extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'extracharge_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'extracharge_group_name'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'extracharge_group_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
