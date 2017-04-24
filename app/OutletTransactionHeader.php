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
        'bill_number', 'total_billed', 'total_discount', 'grand_total', 'desc', 'guest_id', 'date', 'status', 'created_by',
        'waiters', 'guest_num', 'table_id', 'room_id', 'bill_type', 'delivery_type', 'source'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'transaction_id';

    public static function getList ($filter, $limit){
        $where[] = ['status', '<>', 4];

        $source = isset($filter['source']) ? $filter['source'] : 1;
        $where[] = ['source', '=', $source];
        if($filter['status'] != 0) {
            $where[] = ['status', '=', $filter['status']];
        }

        if($filter['bill_number'] != null){
            $where[] = ['bill_number', '=', $filter['bill_number']];
        }

        $list = parent::where($where)
                        ->whereBetween('date', [$filter['start'], $filter['end']])
                        ->orderBy('transaction_id', 'desc')
                        ->paginate($limit);

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

    /**
     * @param $id
     * @return string
     */
    public static function getDetailResto($id) {
        $detail = OutletTransactionDetail::select('name', 'outlet_transaction_detail.price', 'qty')
            ->join('pos_item', 'pos_item.id', '=', 'outlet_transaction_detail.extracharge_id')
            ->where('transaction_id', $id)
            ->get();

        $text = array();
        foreach($detail as $key => $val) {
            $text[] = $val->name.' ['.GlobalHelper::moneyFormat($val->price).' x '.$val->qty.']<br />';
        }

        return implode(' ', $text);
    }

    /**
     * @param $type
     * @return string
     */
    public static function getDeliveryType($type){
        if($type == 1){
            return 'Dine In';
        }
        return 'Room Service';
    }
}
