<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    /**
     * @var string
     */
    protected $table = 'costs';

    /**
     * @var array
     */
    protected $fillable = [
        'cost_name', 'cost_status', 'cost_type', 'cost_amount', 'cost_date'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'cost_id';

    public static function setTypeName ($type){
        if($type == 1){
            return 'Fix Cost';
        }
        return 'Variable Cost';
    }

    public static function getCostName ($cost_id){
        return parent::find($cost_id)->value('cost_name');
    }
}
