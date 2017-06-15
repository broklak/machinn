<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extracharge extends Model
{
    use SoftDeletes;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function getStatus ($status){
        if($status == 1){
            return __('web.unpaid');
        }

        return __('web.paid');
    }

    public static function getTypeName($typeId){
        if($typeId == 1){
            return __('web.extraTypeOne');
        }

        return __('web.extraTypeReoccur');
    }

    public static function getName ($id){
        $data = parent::find($id);
        return isset($data->extracharge_name) ? $data->extracharge_name : 'DELETED';
    }

    public static function getGroupName ($groupId) {
        $group = ExtrachargeGroup::find($groupId);

        return (isset($group->extracharge_group_name)) ? $group->extracharge_group_name : '';
    }
}
