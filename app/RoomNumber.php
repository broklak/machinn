<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomNumber extends Model
{
    /**
     * @var string
     */
    protected $table = 'room_numbers';

    /**
     * @var array
     */
    protected $fillable = [
        'room_number_code', 'room_type_id', 'room_floor_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'room_number_id';

    public static function getTypeName ($typeId) {
        $type = RoomType::find($typeId);

        return $type->room_type_name;
    }

    public static function getFloorName ($floorId) {
        $floor = PropertyFloor::find($floorId);

        return $floor->property_floor_name;
    }

    public static function setButtonStatus($status){
        if($status == 1){
            return 'success';
        } elseif($status == 2){
            return 'primary';
        } elseif($status == 3){
            return 'warning';
        } elseif ($status == 4){
            return 'info';
        } elseif($status == 5){
            return 'inverse';
        } else{
            return 'important';
        }
    }

    public static function setStatusName($status){
        if($status == 1){
            return 'Vacant';
        } elseif($status == 2){
            return 'Occupied';
        } elseif($status == 3){
            return 'Guaranteed Booking';
        } elseif ($status == 4){
            return 'Tentative Booking';
        } elseif($status == 5){
            return 'Dirty';
        } else{
            return 'Out of Order';
        }
    }
}
