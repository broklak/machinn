<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDeposit extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking_deposit';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id', 'amount', 'status', 'created_by', 'updated_by', 'desc', 'refund_amount'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';
}
