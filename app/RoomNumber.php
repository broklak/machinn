<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RoomNumber
 * @package App
 */
class RoomNumber extends Model
{
    use SoftDeletes;
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param $typeId
     * @return mixed
     */
    public static function getTypeName ($typeId) {
        $type = RoomType::find($typeId);

        return isset($type->room_type_name) ? $type->room_type_name : 'DELETED';
    }

    /**
     * @param $planId
     * @return mixed
     */
    public static function getPlanName ($planId) {
        $plan = RoomPlan::find($planId);

        return isset($plan->room_plan_name) ? $plan->room_plan_name : 'DELETED';
    }

    /**
     * @param $floorId
     * @return mixed
     */
    public static function getFloorName ($floorId) {
        $floor = PropertyFloor::find($floorId);

        return isset($floor->property_floor_name) ? $floor->property_floor_name : 'DELETED';
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getCode ($id){
        $data = parent::find($id);
        return isset($data->room_number_code) ? $data->room_number_code : 'DELETED';
    }

    /**
     * @param $checkinDate
     * @param $checkoutDate
     * @param array $filter
     * @return mixed
     */
    public static function getRoomAvailable ($checkinDate, $checkoutDate, $filter = array()){
        $checkoutDate = date('Y-m-d', strtotime($checkoutDate) - 3600); // ROOM CAN BE USED ON CHECKOUT DATE (kurangi 1 hari dari jadwal checkout)
        $banquet = (isset($filter['banquet'])) ? $filter['banquet'] : 0;

        $where = [];
        $where[] = ['room_numbers.deleted_at', '=', null];
        $where[] = ['room_type_banquet', '=', $banquet];
        if(isset($filter['type']) && $filter['type'] != 0) {
            $where[] = ['room_numbers.room_type_id', '=', $filter['type']];
        }

        if(isset($filter['floor']) && $filter['floor'] != 0) {
            $where[] = ['room_floor_id', '=', $filter['floor']];
        }

        $getRoom = DB::table('room_numbers')
                    ->select(DB::raw("room_number_id, room_numbers.room_type_id, room_number_code, room_type_name, property_floor_name, hk_status,
                      (select count(*) from booking_room where room_number_id = room_numbers.room_number_id
                      and room_transaction_date between '$checkinDate' and '$checkoutDate' and status IN (2,3,4,6) and checkout = 0) as room_used,
                      (select status from booking_room where room_number_id = room_numbers.room_number_id AND room_transaction_date = '$checkinDate') AS status,
                      (select booking_id from booking_room where room_number_id = room_numbers.room_number_id AND room_transaction_date = '$checkinDate') AS booking_id,
                      (select room_price from room_rates where room_rate_day_type_id = 1 and room_rate_type_id = room_numbers.room_type_id) as room_rate_weekdays,
                      (select room_price from room_rates where room_rate_day_type_id = 2 and room_rate_type_id = room_numbers.room_type_id) as room_rate_weekends"))
                    ->rightJoin('room_types', 'room_numbers.room_type_id', '=', 'room_types.room_type_id')
                    ->rightJoin('property_floors', 'property_floors.property_floor_id', '=', 'room_numbers.room_floor_id')
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
