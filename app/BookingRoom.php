<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingRoom extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking_room';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id', 'room_number_id', 'room_rate', 'room_transaction_date', 'notes', 'checkout_date', 'status',
        'created_by', 'updated_by', 'room_plan_rate', 'guest_id', 'discount', 'subtotal'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_room_id';

    /**
     * @param $input
     * @param $header
     * @param string $source
     * @return int
     */
    public static function processBookingRoom($input, $header, $source = 'booking') {
        // DELETE FIRST
        parent::where('booking_id', $header->booking_id)->delete();

        $checkin = strtotime($input['checkin_date']);
        $checkout = strtotime($input['checkout_date']);
        $datediff = floor(abs($checkin - $checkout)) / (60 * 60 * 24);
        $weekdayList = RoomRateDateType::getListDay(1);

        $getRoomPlan = RoomPlan::find($input['room_plan_id']);
        $cost = $getRoomPlan->room_plan_additional_cost;

        if($source == 'booking'){
            $status = ($input['type'] == 1) ? 3 : 4;
        } else {
            $status = 2;
        }

        for($i = 0;$i < $datediff; $i++){
            $nextDay = $checkin + (86400 * $i);
            $room_number = explode(',',$input['room_number']);
            $room_number = array_filter($room_number);

            foreach($room_number as $val){
                $bookingRoom = [
                    "booking_id"    => $header->booking_id,
                    "guest_id"      => $header->guest_id,
                    "room_number_id" => $val,
                    "room_transaction_date" => date('Y-m-d', $nextDay),
                    "status"        => $status,
                    "created_by"    => Auth::id(),
                    "room_plan_rate" => $cost
                ];
                $dayCheckin = date('l', $nextDay);
                if(in_array(strtolower($dayCheckin), $weekdayList)){
                    $bookingRoom['room_rate'] = RoomNumber::getRoomRatesById($val, 1);
                } else {
                    $bookingRoom['room_rate'] = RoomNumber::getRoomRatesById($val, 2);
                }
                $bookingRoom['subtotal'] = $bookingRoom['room_rate'] + $bookingRoom['room_plan_rate'];

                parent::create($bookingRoom);
            }
        }

        return 1;
    }

    /**
     * @param string $start
     * @param string $end
     * @return mixed
     */
    public static function getAllRoomBooked ($start, $end){
        $getRoom = DB::table('booking_room')
            ->select(DB::raw('booking_room.booking_id,booking_room.room_number_id, booking_room.status, first_name, last_name, room_transaction_date'))
            ->whereBetween('room_transaction_date', [$start, $end])
            ->whereIn('booking_room.status', [2,3,4,6])
            ->join('guests', 'booking_room.guest_id', '=', 'guests.guest_id')
            ->get();

        return $getRoom;
    }
}
