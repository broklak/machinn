<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extracharge extends Model
{
    /**
     * @var string
     */
    protected $table = 'extracharges';

    /**
     * @var array
     */
    protected $fillable = [
        'extracharge_name', 'extracharge_group_id', 'extracharge_type', 'extracharge_price'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'extracharge_id';

    public static function getTypeName($typeId){
        if($typeId == 1){
            return 'One Time';
        }

        return 'Reoccuring';
    }

    public static function getName ($id){
        $data = parent::find($id);
        return $data->extracharge_name;
    }

    public static function getGroupName ($groupId) {
        $group = ExtrachargeGroup::find($groupId);

        return $group->extracharge_group_name;
    }
}
