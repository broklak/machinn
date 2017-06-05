<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    /**
     * @param $filter
     * @param bool $csv
     * @return mixed
     */
    public function guestBill($filter, $csv = false) {
        $where[] = ['booking_header.checkout', '=', 1];

        $limit = ($csv) ? 1000000000 : config('app.limitPerPage');

        $getBooking = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_code, room_list, first_name, last_name, checkin_date, checkout_date,
                            (select count(*) from booking_room where booking_id = booking_header.booking_id) as room_num,
                            booking_header.partner_id, partner_name, booking_header.type, booking_status,checkout,
                            (select total_payment from booking_payment where booking_id = booking_header.booking_id and type = 1 limit 1) as down_payment,
                            booking_header.grand_total, (select SUM(total_payment) from booking_extracharge where booking_id = booking_header.booking_id GROUP BY booking_id) as extra,
                            (select SUM(total_payment) from booking_payment where payment_method IN (1,2) AND deposit = 0 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_cash,
                            (select SUM(total_payment) from booking_payment where payment_method = 3 AND deposit = 0 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_credit,
                            (select SUM(total_payment) from booking_payment where payment_method = 4 AND deposit = 0 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_bank,
                            (select SUM(total_payment) from booking_payment where type = 5 AND booking_id = booking_header.booking_id AND deposit = 0 GROUP BY booking_id) as refund,
                            (select SUM(total_payment) from booking_payment where type <> 5 AND deposit = 0 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_received,
                            (select name from users where id = booking_header.created_by) as creby, (select name from users where id = booking_header.updated_by) as modby
                            '))
            ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
            ->leftJoin('partners', 'booking_header.partner_id', '=', 'partners.partner_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($where)
            ->whereBetween('checkin_date', [$filter['start'], $filter['end']])
            ->paginate($limit);

        $booking = array();
        foreach($getBooking as $row) {
            $booking[] = ($csv) ? (array) $row : $row;
        }

        $data['booking'] = $booking;
        $data['link'] = $getBooking->links();

        return $data;
    }

    public function cashCredit($filter, $down = 1) {
        $whereAll[] = ['booking_payment.type', '=', $down];
        $whereCashFo = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 1]
        ];

        $whereCashBo = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 2]
        ];

        $whereCredit = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 3]
        ];

        $whereBank = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 4]
        ];

        $dataAll = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list,
                        (select total_payment from booking_payment where booking_id = booking_header.booking_id and payment_method IN (1,2) limit 1) as total_cash,
                        (select total_payment from booking_payment where booking_id = booking_header.booking_id and payment_method = 3 limit 1) as total_credit,
                        (select total_payment from booking_payment where booking_id = booking_header.booking_id and payment_method = 4 limit 1) as total_bank,
                        total_payment,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereAll)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();


        $datacashFo = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereCashFo)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $datacashBo = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereCashBo)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $dataCredit = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        bank_name, cc_type_name,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->join('banks', 'banks.bank_id', '=', 'booking_payment.bank')
            ->join('cc_types', 'cc_types.cc_type_id', '=', 'booking_payment.cc_type_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereCredit)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $dataBank = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        cash_account_name,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->join('cash_accounts', 'booking_payment.bank_transfer_recipient', '=', 'cash_accounts.cash_account_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereBank)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $data['all'] = $dataAll;
        $data['cashfo'] = $datacashFo;
        $data['cashbo'] = $datacashBo;
        $data['credit'] = $dataCredit;
        $data['bank'] = $dataBank;

        return $data;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function downPayment($filter) {
        $where = [];
        $start = date('Y-m-d 00:00:00', strtotime($filter['start']));
        $end = date('Y-m-d 23:59:59', strtotime($filter['end']));
        if(isset($filter['status']) && $filter['status'] != -1){
            $where[] = ['status', '=', $filter['status']];
        }
        $data = DB::table('booking_deposit')
            ->select(DB::raw('booking_code, booking_deposit.status, amount, booking_deposit.created_at,
                    (select username from users where id = booking_deposit.updated_by) AS refunded_by, booking_deposit.desc, refund_amount, (amount - refund_amount) AS total_kept'))
            ->join('booking_header', 'booking_header.booking_id', '=', 'booking_deposit.booking_id')
            ->where($where)
            ->whereBetween('booking_deposit.created_at', [$start, $end])
            ->paginate(config('app.limitPerPage'));

        return $data;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function source($filter) {
        $data = DB::table('partners')
                        ->select(DB::raw("distinct(partners.partner_id), partner_name, (SELECT SUM(grand_total) from booking_header where
                                 booking_status = 2 and partner_id = partners.partner_id
                                AND checkout_date BETWEEN '".$filter['start']."' AND '".$filter['end']."'
                                GROUP BY partner_id) AS total_bills"))
                        ->leftJoin('booking_header', 'booking_header.partner_id', '=', 'partners.partner_id')
                        ->whereBetween('booking_header.checkout_date', [$filter['start'], $filter['end']])
                        ->get();
        return $data;
    }

    /**
     * @param $start
     * @param int $type
     * @param bool $csv
     * @return mixed
     */
    public function getArrival ($start, $type = 1, $csv = false){
        $type = ($type == 1) ? 'checkin_date' : 'checkout_date';
        $limit = ($csv) ? 1000000000 : config('app.limitPerPage');
        $getBooking = DB::table('booking_header')
                    ->select(DB::raw("booking_code, checkin_date, checkout_date, room_list, first_name, last_name, title, adult_num, child_num,
                        (select count(*) from booking_room where booking_id = booking_header.booking_id AND room_transaction_date = '$start'  GROUP BY booking_id)
                        AS total_room"))
                    ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
                    ->where($type, $start)
                    ->paginate($limit);

        return $getBooking;
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getOccupied ($date){
        $occupied = DB::table('booking_header')
                        ->select(DB::raw("(SUM(ANY_VALUE(adult_num)) + SUM(ANY_VALUE(child_num))) as total_guest"))
                        ->where('checkin_date', '<=', $date)
                        ->where('checkout_date', '>', $date)
                        ->where('booking_status', 2)
                        ->groupBy("checkin_date")
                        ->first();

        return $occupied;
    }

    /**
     * @param int $status
     * @param bool $csv
     * @return mixed
     */
    public function getOutstandingBooking ($status = 0, $csv = false){
        $where[] = ['payment_status', '<>', 3];
        $limit = ($csv) ? 1000000000 : config('app.limitPerPage');
        if($status != 0){
            $where[] = ['booking_status', '=', $status];
        }
        $outstanding = DB::table('booking_header')
                            ->select(DB::raw('booking_code, first_name, last_name, partner_name, checkin_date, checkout_date, grand_total, booking_status
                                , (select SUM(total_payment) from booking_extracharge where booking_id = booking_header.booking_id
                                group by booking_id) AS total_extra,
                                (select SUM(total_payment) from booking_payment where booking_id = booking_header.booking_id
                                group by booking_id) AS total_paid'))
                            ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
                            ->join('partners', 'booking_header.partner_id', '=', 'partners.partner_id')
                            ->where($where)
                            ->whereIn('booking_status', [1,2])
                            ->paginate($limit);

        return $outstanding;
    }

    /**
     * @param $start
     * @param $end
     * @param $status
     * @return mixed
     */
    public function getVoid($start, $end, $status){
        $where = [];
        if($status != 0){
            $where[] = ['booking_status', '=', $status];
        }

        $void = DB::table('booking_header')
                    ->select(DB::raw('booking_code, first_name, last_name, partner_name, checkin_date, checkout_date, booking_status, room_list,
                              booking_header.updated_by'))
                    ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
                    ->join('partners', 'booking_header.partner_id', '=', 'partners.partner_id')
                    ->where($where)
                    ->whereIn('booking_status', [3,4])
                    ->whereBetween('booking_header.checkout_date', [$start, $end])
                    ->paginate(config('app.limitPerPage'));

        return $void;
    }
}
