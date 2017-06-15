<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            return __('web.draft');
        } elseif($status == 2) {
            return __('web.billed');
        } elseif($status == 3){
            return __('web.paid');
        } else {
            return __('web.deleted');
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function getDeliveryStatus($status){
        if($status == 1){
            return '<span class="label label-success">'.__('web.deliveryStatusYes').'</span>';
        }

        return '<span class="label label-warning">'.__('web.deliveryStatusNo').'</span>';
    }

    /**
     * @param $filter
     * @param int $limit
     * @param null $order_by
     * @return mixed
     */
    public static function itemReport($filter, $limit = 100, $order_by = null){
        if($order_by == 1 || $order_by == null){
            $by = 'name';
            $type = 'asc';
        } elseif($order_by == 2){
            $by = 'name';
            $type = 'desc';
        } elseif($order_by == 3){
            $by = 'total_sales';
            $type = 'asc';
        } else {
            $by = 'total_sales';
            $type = 'desc';
        }
        $start = date('Y-m-d 00:00:00', strtotime($filter['start']));
        $end = date('Y-m-d 23:59:59', strtotime($filter['end']));

        $data = DB::table('pos_item')
                    ->select(DB::raw("name, cost_basic, cost_sales, stock,
                            (SELECT SUM(qty) from outlet_transaction_detail od
                             INNER JOIN outlet_transaction_header oh on oh.transaction_id = od.transaction_id
                             where extracharge_id = pos_item.id and oh.status = 3 and source = 2
                            and od.updated_at BETWEEN '$start' AND '$end') AS total_qty,

                            (SELECT SUM(subtotal) from outlet_transaction_detail od
                              INNER JOIN outlet_transaction_header oh on oh.transaction_id = od.transaction_id
                             where extracharge_id = pos_item.id and oh.status = 3
                            and od.updated_at BETWEEN '$start' AND '$end'
                             AND source = 2) AS total_sales"))
                    ->join('outlet_transaction_detail', 'outlet_transaction_detail.extracharge_id', '=', 'pos_item.id')
                    ->join('outlet_transaction_header', 'outlet_transaction_header.transaction_id', '=', 'outlet_transaction_detail.transaction_id')
                    ->where('outlet_transaction_header.status', 3)
                    ->where('outlet_transaction_header.source', 2)
                    ->groupBy('pos_item.id')
                    ->orderBy($by, $type)
                    ->paginate($limit);

        return $data;
    }
}
