<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'room_types';

    /**
     * @var array
     */
    protected $fillable = [
        'room_type_name', 'room_type_attributes', 'room_type_max_adult', 'room_type_max_child', 'room_type_banquet'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_type_id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function getAttributeName ($attributeId) {
        $attribute = RoomAttribute::find($attributeId);

        return isset($attribute->room_attribute_name) ? $attribute->room_attribute_name : __('web.deleted');
    }
}
