<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    /**
     * @var string
     */
    protected $table = 'booking_payment';

    /**
     * @var array
     */
    protected $fillable = [
        'booking_id', 'payment_method', 'type', 'total_payment', 'card_type', 'card_number', 'cc_type_id', 'bank', 'settlement_id', 'card_name', 'card_expiry_month', 'card_expiry_year', 'bank_transfer_recipient', 'created_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'booking_payment_id';
}
