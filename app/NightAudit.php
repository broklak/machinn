<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NightAudit extends Model
{
    protected $table = 'night_audit';

    /**
     * @var array
     */
    protected $fillable = [
        'type', 'audited_by', 'booking_id', 'transaction_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param $start
     * @param $end
     * @param $status
     * @return mixed
     */
    public static function getRoomAudit($start, $end, $status){
        $where[] = ['checkout', '=', 1];
        $where[] = ['payment_status', '=', 3];
        $where[] = ['audited', '=', $status];

        $void = DB::table('booking_header')
            ->select(DB::raw('booking_id ,booking_code, first_name, last_name, partner_name, checkin_date, checkout_date, booking_status, room_list,
                              audited, grand_total'))
            ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
            ->join('partners', 'booking_header.partner_id', '=', 'partners.partner_id')
            ->where($where)
            ->whereBetween('booking_header.checkout_date', [$start, $end])
            ->paginate(config('app.limitPerPage'));

        return $void;
    }

    /**
     * @param $start
     * @param $end
     * @param $status
     * @return mixed
     */
    public static function getOutletAudit($start, $end, $status){
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));
        $where[] = ['status', '=', 3];
        $where[] = ['audited', '=', $status];

        $void = DB::table('outlet_transaction_header')
            ->select(DB::raw('transaction_id,bill_number, delivery_type, guest_id, created_at, room_id, table_id, grand_total, audited'))
            ->where($where)
            ->whereBetween('created_at', [$start, $end])
            ->paginate(config('app.limitPerPage'));

        return $void;
    }
}
