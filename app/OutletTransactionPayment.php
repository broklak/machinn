<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutletTransactionPayment extends Model
{
    /**
     * @var string
     */
    protected $table = 'outlet_transaction_payment';

    /**
     * @var array
     */
    protected $fillable = [
        'transaction_id', 'payment_method', 'total_payment', 'card_type', 'card_number', 'cc_type_id', 'bank', 'settlement_id', 'card_name',
        'card_expiry_month', 'card_expiry_year', 'bank_transfer_recipient', 'created_by', 'guest_id', 'total_paid', 'total_change', 'cc_holder'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public static function getIncome ($start, $end){
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));

        $payment = parent::whereBetween('created_at', [$start, $end])->get();

        $total = 0;
        foreach($payment as $key => $val){
            $total = $total + $val->total_payment;
        }

        return $total;
    }
}
