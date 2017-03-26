<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'booking_id', 'room_number_id', 'room_rate', 'room_transaction_date', 'notes', 'checkout_date', 'status', 'created_by', 'updated_by', 'room_plan_rate'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_room_id';
}
