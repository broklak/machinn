<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
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

    public static function getAttributeName ($attributeId) {
        $attribute = RoomAttribute::find($attributeId);

        return $attribute->room_attribute_name;
    }
}
