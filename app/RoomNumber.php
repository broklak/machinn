<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class RoomNumber
 * @package App
 */
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

    /**
     * @param $typeId
     * @return mixed
     */
    public static function getTypeName ($typeId) {
        $type = RoomType::find($typeId);

        return $type->room_type_name;
    }

    /**
     * @param $floorId
     * @return mixed
     */
    public static function getFloorName ($floorId) {
        $floor = PropertyFloor::find($floorId);

        return $floor->property_floor_name;
    }

    /**
     * @param $checkinDate
     * @param $checkoutDate
     * @param array $filter
     * @return mixed
     */
    public static function getRoomAvailable ($checkinDate, $checkoutDate, $filter = array()){
        $checkoutDate = date('Y-m-d', strtotime($checkoutDate) - 3600); // ROOM CAN BE USED ON CHECKOUT DATE (kurangi 1 hari dari jadwal checkout)

        $where = [];
        if(isset($filter['type']) && $filter['type'] != 0) {
            $where[] = ['room_numbers.room_type_id', '=', $filter['type']];
        }

        if(isset($filter['floor']) && $filter['floor'] != 0) {
            $where[] = ['room_floor_id', '=', $filter['floor']];
        }

        $getRoom = DB::table('room_numbers')
                    ->select(DB::raw("room_number_id, room_numbers.room_type_id, room_number_code, room_type_name, property_floor_name,
                      (select count(*) from booking_room where room_number_id = room_numbers.room_number_id
                      and room_transaction_date between '$checkinDate' and '$checkoutDate' and status NOT IN (1,5,7,8)) as room_available,
                      (select room_price from room_rates where room_rate_day_type_id = 1 and room_rate_type_id = room_numbers.room_type_id) as room_rate_weekdays,
                      (select room_price from room_rates where room_rate_day_type_id = 2 and room_rate_type_id = room_numbers.room_type_id) as room_rate_weekends"))
                    ->join('room_types', 'room_numbers.room_type_id', '=', 'room_types.room_type_id')
                    ->join('property_floors', 'property_floors.property_floor_id', '=', 'room_numbers.room_floor_id')
                    ->having('room_available', '=', 0)
                    ->where($where)
                    ->get();

        return $getRoom;
    }

    /**
     * @param $roomId
     * @param $rateTypeId
     * @return mixed
     */
    public static function getRoomRatesById($roomId, $rateTypeId) {
        $getprice = DB::table('room_rates')
                    ->join('room_numbers', 'room_numbers.room_type_id', '=', 'room_rates.room_rate_type_id')
                    ->where('room_number_id', $roomId)
                    ->where('room_rate_day_type_id', $rateTypeId)
                    ->value('room_price');

        return $getprice;
    }

    /**
     * @param $roomIdList
     * @return array
     */
    public static function getRoomDataList($roomIdList){
        $roomList = explode(',', $roomIdList);
        $roomData = [];
        foreach($roomList as $val){
            $getCode = parent::find($val);
            $roomData[$val]['code'] = $getCode->room_number_code;
            $roomData[$val]['type'] = $getCode->room_type_id;
            $roomData[$val]['rateWeekdays'] = self::getRoomRatesById($val, 1);
            $roomData[$val]['rateWeekends'] = self::getRoomRatesById($val, 2);
        }
        return $roomData;
    }

    /**
     * @param $roomIdList
     * @return string
     */
    public static function getRoomCodeList ($roomIdList){
        $roomList = explode(',', $roomIdList);
        $roomData = [];
        foreach($roomList as $val){
            $getCode = parent::find($val);
            $roomData[] = $getCode->room_number_code;
        }
        return implode(', ', $roomData);
    }

}
