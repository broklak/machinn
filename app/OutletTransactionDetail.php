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
        'transaction_id', 'extracharge_id', 'price', 'qty', 'discount', 'subtotal', 'status', 'created_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

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
}
