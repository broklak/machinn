<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtrachargeGroup extends Model
{
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
}
