<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookingHeader extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking_header';

    /**
     * @var array
     */
    protected $fillable = [
        'guest_id', 'room_plan_id', 'partner_id', 'type', 'checkin_date', 'checkout_date', 'adult_num',
        'child_num', 'is_banquet', 'booking_status', 'payment_status', 'created_by', 'updated_by', 'grand_total', 'notes'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_id';

    /**
     * @param array $filter
     * @return mixed
     */
    public static function getBooking($filter = array()){
        $where = [];
        $orWhere = [];

        if(isset($filter['status']) && $filter['status'] != 0) {
            $where[] = ['booking_header.booking_status', '=', $filter['status']];
        }
        $guest = $filter['guest'];

        $getBooking = DB::table('booking_header')
                        ->select(DB::raw('booking_header.guest_id, first_name, last_name, id_number, id_type, handphone, checkin_date, checkout_date,
                            (select count(*) from booking_room where booking_id = booking_header.booking_id) as room_num, partner_name, booking_header.type,
                            (select total_payment from booking_payment where booking_id = booking_header.booking_id and type = 1 limit 1) as down_payment'))
                        ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
                        ->join('partners', 'booking_header.partner_id', '=', 'partners.partner_id')
                        ->orderBy('booking_header.booking_id', 'desc')
                        ->where($where)
                        ->whereRaw("(last_name LIKE '%$guest%' OR first_name LIKE '%$guest%')")
                        ->paginate(config('app.limitPerPage'));

        $booking = array();
        foreach($getBooking as $row) {
            $booking[] = $row;
        }

        $data['booking'] = $booking;
        $data['link'] = $getBooking->links();

        return $data;
    }

    /**
     * @param $type
     * @return string
     */
    public static function getBookingTypeName ($type) {
        if($type == 1){
            return 'Guaranteed';
        }
        return 'Tentative';
    }
}
