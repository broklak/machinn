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
}
