<?php

namespace App;

use App\Helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;

class OutletTransactionHeader extends Model
{
    /**
     * @var string
     */
    protected $table = 'outlet_transaction_header';

    /**
     * @var array
     */
    protected $fillable = [
        'bill_number', 'total_billed', 'total_discount', 'grand_total', 'desc', 'guest_id', 'date', 'status', 'created_by'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'transaction_id';

    public static function getList ($filter, $limit){
        $where[] = ['status', '<>', 4];

        if($filter['status'] != 0) {
            $where[] = ['status', '=', $filter['status']];
        }

        if($filter['bill_number'] != null){
            $where[] = ['bill_number', '=', $filter['bill_number']];
        }

        $list = parent::where($where)->whereBetween('date', [$filter['start'], $filter['end']])->paginate($limit);

        return $list;
    }

    public static function getDetail($id) {
        $detail = OutletTransactionDetail::select('extracharge_name', 'outlet_transaction_detail.price', 'qty')
                    ->join('extracharges', 'extracharges.extracharge_id', '=', 'outlet_transaction_detail.extracharge_id')
                    ->where('transaction_id', $id)
                    ->get();

        $text = array();
        foreach($detail as $key => $val) {
            $text[] = $val->extracharge_name.' ['.GlobalHelper::moneyFormat($val->price).' x '.$val->qty.']<br />';
        }

        return implode(' ', $text);
    }
}
