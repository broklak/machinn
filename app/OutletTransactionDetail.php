<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutletTransactionDetail extends Model
{
    /**
     * @var string
     */
    protected $table = 'outlet_transaction_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'transaction_id', 'extracharge_id', 'price', 'qty', 'discount', 'subtotal', 'status', 'created_by', 'delivery_status'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $status
     * @return string
     */
    public static function getStatusName ($status) {
        if($status == 1){
            return 'Draft';
        } elseif($status == 2) {
            return 'Billed';
        } elseif($status == 3){
            return 'Paid';
        } else {
            return 'Deleted';
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function getDeliveryStatus($status){
        if($status == 1){
            return '<span class="label label-success">Delivered</span>';
        }

        return '<span class="label label-warning">Not Delivered</span>';
    }
}
