<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingExtracharge extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking_extracharge';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id', 'guest_id', 'booking_room_id', 'extracharge_id', 'qty', 'price',
        'discount', 'total_payment', 'status', 'created_by', 'updated_by', 'checkout'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_extracharge_id';

    /**
     * @param $bookingId
     * @return mixed
     */
    public static function getTotalUnpaid($bookingId){
        return parent::where('booking_id', $bookingId)->where('status', 1)->sum('total_payment');
    }

    /**
     * @param $start
     * @param $end
     * @return int
     */
    public static function getIncome ($start, $end){
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));

        $payment = parent::whereBetween('created_at', [$start, $end])->where('status', 2)->get();

        $total = 0;
        foreach($payment as $key => $val){
            $total = $total + $val->total_payment;
        }

        return $total;
    }
}
