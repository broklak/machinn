<?php

namespace App\Http\Controllers\Back;

use App\BookingExtracharge;
use App\BookingHeader;
use App\BookingPayment;
use App\BookingRoom;
use App\CashAccount;
use App\CashTransaction;
use App\Cost;
use App\Department;
use App\FrontExpenses;
use App\Guest;
use App\Helpers\GlobalHelper;
use App\OutletTransactionDetail;
use App\OutletTransactionHeader;
use App\OutletTransactionPayment;
use App\Partner;
use App\PropertyAttribute;
use App\Report;
use App\RoomNumber;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * @var
     */
    private $model;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Report();
    }

    public function guestBill (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->guestBill($filter, $csv = true);
        $data = $report['booking'];
        $csv = [];
        foreach($data as $key => $value){
            $csv[$key]['booking_code'] = $value['booking_code'];
            $csv[$key]['guest_name'] = $value['first_name'].' '.$value['last_name'];
            $csv[$key]['room_list'] = RoomNumber::getRoomCodeList($value['room_list']);
            $csv[$key]['checkin_date'] = date('j F Y', strtotime($value['checkin_date']));
            $csv[$key]['checkout_date'] = date('j F Y', strtotime($value['checkout_date']));
            $csv[$key]['partner'] = $value['partner_name'];
            $csv[$key]['total_bill'] = GlobalHelper::moneyFormat($value['total_received']);
        }

        return Excel::create('GuestBillReport_'.$monthWord.'_'.$year, function($excel) use ($csv) {
            $excel->sheet('GuestBillReport', function($sheet) use ($csv)
            {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deposit (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->downPayment($filter);
        $data = $report['all'];

        $csv = [];
        foreach($data as $key => $value) {
            $csv[$key]['booking_code'] = $value->booking_code;
            $csv[$key]['date'] = date('j F Y', strtotime($value->created_at));
            $csv[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csv[$key]['total_deposit'] = GlobalHelper::moneyFormat($value->total_payment);

        }
        return Excel::create('DepositReport_'.$monthWord.'_'.$year, function($excel) use ($csv) {
            $excel->sheet('DepositReport', function($sheet) use ($csv)
            {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cashCredit (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->downPayment($filter, $down = 4);
        $data = $report['all'];

        $csv = [];
        foreach($data as $key => $value) {
            $csv[$key]['booking_code'] = $value->booking_code;
            $csv[$key]['date'] = date('j F Y', strtotime($value->created_at));
            $csv[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csv[$key]['total_payment'] = GlobalHelper::moneyFormat($value->total_payment);

        }
        return Excel::create('CashAndCredit_'.$monthWord.'_'.$year, function($excel) use ($csv) {
            $excel->sheet('CashAndCredit', function($sheet) use ($csv)
            {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function frontPos(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 months'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $filter['bill_number'] = $request->input('bill_number');
        $filter['status'] = $request->input('status');
        $monthWord = date('j_F_Y', strtotime($filter['end']));
        $rows = OutletTransactionHeader::getList($filter, 2000000000);

        $data = $rows;
        $csv = [];
        foreach ($data as $key => $value) {
            $csv[$key]['bill_number'] = $value->bill_number;
            $csv[$key]['date'] = date('j F Y', strtotime($value->date));
            $csv[$key]['guest'] = ($value->guest_id == 0) ? 'Non Guest' : Guest::getFullName($value->guest_id);
            $csv[$key]['detail'] = str_replace("<br />", "\n", OutletTransactionHeader::getDetail($value->transaction_id));
            $csv[$key]['total'] = GlobalHelper::moneyFormat($value->grand_total);
            $csv[$key]['status'] = OutletTransactionDetail::getStatusName($value->status);
        }
        return Excel::create('OutletPostingReport_' . $monthWord, function ($excel) use ($csv) {
            $excel->sheet('OutletPostingReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function source (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->source($filter);

        $csv = [];

        foreach ($report as $key => $item) {
            $csv[$key]['partner_name'] = $item->partner_name;
            $csv[$key]['total_bills'] = ($item->total_bills == null) ? GlobalHelper::moneyFormat(0) : GlobalHelper::moneyFormat($item->total_bills);
        }

        return Excel::create('BusinessSourceReport_' . $monthWord.'_'.$year, function ($excel) use ($csv) {
            $excel->sheet('BusinessSourceReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function booking(Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = 'report-front';
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));

        $activeList = BookingHeader::getBookingReport($status = 1);
        $checkinList = BookingHeader::getBookingReport($status = 2);
        $noshowList = BookingHeader::getBookingReport($status = 3);
        $voidList = BookingHeader::getBookingReport($status = 4);

        $csvActive = [];
        $csvCheckin = [];
        $csvNoshow = [];
        $csvVoid = [];

        foreach($activeList as $key => $value){
            $csvActive[$key]['booking_code'] = $value->booking_code;
            $csvActive[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csvActive[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csvActive[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csvActive[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csvActive[$key]['total_night'] = $value->total_night;
            $csvActive[$key]['partner_name'] = $value->partner_name;
            $csvActive[$key]['status'] = GlobalHelper::getBookingStatus($value->booking_status);
        }

        foreach($checkinList as $key => $value){
            $csvCheckin[$key]['booking_code'] = $value->booking_code;
            $csvCheckin[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csvCheckin[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csvCheckin[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csvCheckin[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csvCheckin[$key]['total_night'] = $value->total_night;
            $csvCheckin[$key]['partner_name'] = $value->partner_name;
            $csvCheckin[$key]['status'] = GlobalHelper::getBookingStatus($value->booking_status);
        }

        foreach($noshowList as $key => $value){
            $csvNoshow[$key]['booking_code'] = $value->booking_code;
            $csvNoshow[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csvNoshow[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csvNoshow[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csvNoshow[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csvNoshow[$key]['total_night'] = $value->total_night;
            $csvNoshow[$key]['partner_name'] = $value->partner_name;
            $csvNoshow[$key]['status'] = GlobalHelper::getBookingStatus($value->booking_status);
        }

        foreach($voidList as $key => $value){
            $csvVoid[$key]['booking_code'] = $value->booking_code;
            $csvVoid[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csvVoid[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csvVoid[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csvVoid[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csvVoid[$key]['total_night'] = $value->total_night;
            $csvVoid[$key]['partner_name'] = $value->partner_name;
            $csvVoid[$key]['status'] = GlobalHelper::getBookingStatus($value->booking_status);
        }

        return Excel::create('BookingReport_' . $monthWord.'-'.$year, function ($excel) use ($csvActive, $csvCheckin, $csvNoshow, $csvVoid) {
            $excel->sheet('Active Booking', function ($sheet) use ($csvActive) {
                $sheet->fromArray($csvActive);
            });

            $excel->sheet('Check In Booking', function ($sheet) use ($csvCheckin) {
                $sheet->fromArray($csvCheckin);
            });

            $excel->sheet('No Show Booking', function ($sheet) use ($csvNoshow) {
                $sheet->fromArray($csvNoshow);
            });

            $excel->sheet('Void Booking', function ($sheet) use ($csvVoid) {
                $sheet->fromArray($csvVoid);
            });
        })->download();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function salespos (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));
        $filter['start'] = date("$year-$month-01");
        $filter['end'] = date("$year-$month-t");
        $filter['status'] = 3;
        $filter['source'] = 2;
        $filter['delivery_type'] = ($request->input('delivery_type')) ? $request->input('delivery_type') : 0;

        $pos = OutletTransactionHeader::getList($filter, $limit = 1000000);

        $csv = [];

        foreach($pos as $key => $value){
            $csv[$key]['bill_number'] = $value->bill_number;
            $csv[$key]['date'] = date('j F Y', strtotime($value->date));
            $csv[$key]['guest'] = ($value->guest_id == 0) ? 'Non Guest' : Guest::getFullName($value->guest_id);
            $csv[$key]['total_bill'] = GlobalHelper::moneyFormat($value->total_billed);
            $csv[$key]['total_tax'] = GlobalHelper::moneyFormat($value->total_tax);
            $csv[$key]['total_service'] = GlobalHelper::moneyFormat($value->total_service);
            $csv[$key]['total_discount'] = GlobalHelper::moneyFormat($value->total_discount);
            $csv[$key]['grand_total'] = GlobalHelper::moneyFormat($value->grand_total);
        }

        return Excel::create('RestoSalesReport_' . $monthWord.'_'.$year, function ($excel) use ($csv) {
            $excel->sheet('RestoSalesReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itempos (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $monthWord = date('F', mktime(0, 0, 0, $month, 10));
        $order = $request->input('order');
        $name = $request->input('name');
        $filter['start'] = date("$year-$month-01");
        $filter['end'] = date("$year-$month-t");
        $filter['name'] = $name;

        $pos = OutletTransactionDetail::itemReport($filter, $limit = 1000000, $order);

        $csv = [];

        foreach($pos as $key => $value){
            $csv[$key]['name'] = $value->name;
            $csv[$key]['basic_cost'] = GlobalHelper::moneyFormat($value->cost_basic);
            $csv[$key]['sales_cost'] = GlobalHelper::moneyFormat($value->cost_sales);
            $csv[$key]['stock'] = $value->stock;
            $csv[$key]['sold_qty'] = $value->total_qty;
            $csv[$key]['sold_amount'] = GlobalHelper::moneyFormat($value->total_sales);
        }

        return Excel::create('RestoItemReport_' . $monthWord.'_'.$year, function ($excel) use ($csv) {
            $excel->sheet('RestoItemReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function arrival (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d');
        $word = date('d_m_Y', strtotime($start));
        $arrival = $this->model->getArrival($start, 1, true);
        $departure = $this->model->getArrival($start, 2, true);

        $csvArrival = [];
        $csvDeparture = [];

        foreach($arrival as $key => $value){
            $csvArrival[$key]['booking_code'] = $value->booking_code;
            $csvArrival[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csvArrival[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csvArrival[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csvArrival[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csvArrival[$key]['total_room'] = $value->total_room;
            $csvArrival[$key]['adult_num'] = $value->adult_num;
            $csvArrival[$key]['child_num'] = $value->child_num;
        }

        foreach($departure as $key => $value){
            $csvDeparture[$key]['booking_code'] = $value->booking_code;
            $csvDeparture[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csvDeparture[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csvDeparture[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csvDeparture[$key]['room_list'] = RoomNumber::getRoomCodeList($value->room_list);
            $csvDeparture[$key]['total_room'] = $value->total_room;
            $csvDeparture[$key]['adult_num'] = $value->adult_num;
            $csvDeparture[$key]['child_num'] = $value->child_num;
        }

        return Excel::create('ArrivalReport_' .$word , function ($excel) use ($csvArrival, $csvDeparture) {
            $excel->sheet('Arrival', function ($sheet) use ($csvArrival) {
                $sheet->fromArray($csvArrival);
            });

            $excel->sheet('Departure', function ($sheet) use ($csvDeparture) {
                $sheet->fromArray($csvDeparture);
            });
        })->download();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function occupied (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $word = date('d_m_Y', strtotime($end));
        $datediff = strtotime($end) - strtotime($start);
        $day = floor($datediff / (60 * 60 * 24));
        $rows = [];
        for($x=0; $x <= $day; $x++){
            $date = date('Y-m-d', strtotime("$start + $x days"));
            $getOccupied = $this->model->getOccupied($date);
            $rows[$x]['date']           = date('j F Y', strtotime("$start + $x days"));
            $rows[$x]['total_guest']     = isset($getOccupied->total_guest) ? $getOccupied->total_guest : 0;
            $rows[$x]['total_room_sold'] = BookingRoom::getTotalRoom(date('Y-m-d', strtotime("$start + $x days")));
            $rows[$x]['total_bill'] = GlobalHelper::moneyFormat(BookingRoom::getTotalRatePerDay(date('Y-m-d', strtotime("$start + $x days"))));
        }

        return Excel::create('RoomOccupiedReport_' . $word, function ($excel) use ($rows) {
            $excel->sheet('RoomOccupiedReport', function ($sheet) use ($rows) {
                $sheet->fromArray($rows);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function outstanding (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $status = ($request->input('status')) ? $request->input('status') : 0;
        $rows = $this->model->getOutstandingBooking($status);

        $csv = [];

        foreach ($rows as $key => $value) {
            $csv[$key]['booking_code'] = $value->booking_code;
            $csv[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csv[$key]['partner_name'] = $value->partner_name;
            $csv[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csv[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csv[$key]['total_bill'] = GlobalHelper::moneyFormat($value->grand_total + $value->total_extra);
            $csv[$key]['total_paid'] = GlobalHelper::moneyFormat($value->total_paid);
            $csv[$key]['total_outstanding'] = GlobalHelper::moneyFormat($value->grand_total + $value->total_extra - $value->total_paid);
        }

        return Excel::create('OutstandingBillReport_'.date('Y_m_d'), function ($excel) use ($csv) {
            $excel->sheet('OutstandingBillReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function void (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $status = ($request->input('status')) ? $request->input('status') : 0;
        $word = date('d_m_Y', strtotime($end));
        $rows = $this->model->getVoid($start, $end, $status);

        $csv = [];
        foreach($rows as $key => $value){
            $csv[$key]['booking_code'] = $value->booking_code;
            $csv[$key]['guest_name'] = $value->first_name.' '.$value->last_name;
            $csv[$key]['business_source'] = $value->partner_name;
            $csv[$key]['checkin_date'] = date('j F Y', strtotime($value->checkin_date));
            $csv[$key]['checkout_date'] = date('j F Y', strtotime($value->checkout_date));
            $csv[$key]['status'] = ($value->booking_status == 3) ? 'No Show' : 'Cancelled';
            $csv[$key]['void_by'] = User::getName($value->updated_by);
        }

        return Excel::create('BookingVoidReport_'.$word, function ($excel) use ($csv) {
            $excel->sheet('BookingVoidReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bank (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $account = ($request->input('cash_account_id')) ? $request->input('cash_account_id') : 0;
        $balance = CashAccount::all();
        $word = date('d_m_Y', strtotime($end));
        $transaction = CashTransaction::getTransaction($start, $end, $account);

        $csvBalance = [];
        $csvTransaction = [];

        foreach($balance as $key => $value){
            $csvBalance[$key]['account_name'] = $value->cash_account_name;
            $csvBalance[$key]['balance'] = GlobalHelper::moneyFormat($value->cash_account_amount);
        }

        foreach($transaction as $key => $value){
            $csvTransaction[$key]['date'] = date('j F Y', strtotime($value->created_at));
            $csvTransaction[$key]['account_name'] = CashAccount::getName($value->cash_account_id);
            $csvTransaction[$key]['description'] = $value->desc;
            $csvTransaction[$key]['debit'] = ($value->type == 1) ? GlobalHelper::moneyFormat($value->amount) : GlobalHelper::moneyFormat(0);
            $csvTransaction[$key]['credit'] = ($value->type == 2) ? GlobalHelper::moneyFormat($value->amount) : GlobalHelper::moneyFormat(0);
        }

        return Excel::create('CashAndBankAccountReport_'.$word, function ($excel) use ($csvBalance, $csvTransaction) {
            $excel->sheet('Balance', function ($sheet) use ($csvBalance) {
                $sheet->fromArray($csvBalance);
            });

            $excel->sheet('Transaction', function ($sheet) use ($csvTransaction) {
                $sheet->fromArray($csvTransaction);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profit(Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $word = date('d_m_Y', strtotime($end));

        $roomIncome = BookingPayment::getIncome($start, $end);
        $restoIncome = OutletTransactionPayment::getIncome($start, $end);
        $extraIncome = BookingExtracharge::getIncome($start, $end);
        $totalIncome = $restoIncome + $roomIncome + $extraIncome;

        $csv = [];

        $csv[0]['name'] = 'Room Income';
        $csv[0]['income'] = GlobalHelper::moneyFormat($roomIncome);
        $csv[0]['expense'] = GlobalHelper::moneyFormat(0);

        $csv[1]['name'] = 'Resto Income Income';
        $csv[1]['income'] = GlobalHelper::moneyFormat($restoIncome);
        $csv[1]['expense'] = GlobalHelper::moneyFormat(0);

        $csv[2]['name'] = 'Extracharge Income';
        $csv[2]['income'] = GlobalHelper::moneyFormat($extraIncome);
        $csv[2]['expense'] = GlobalHelper::moneyFormat(0);

        $expenses = FrontExpenses::getExpensesByCost($start, $end);

        $x=0;
        foreach($expenses as $key => $val){
            $x++;
            $key = $key + 3;

            $csv[$key]['name'] = Cost::getCostName($val->cost_id);
            $csv[$key]['income'] = GlobalHelper::moneyFormat(0);
            $csv[$key]['expense'] = GlobalHelper::moneyFormat($val->total);
        }
        $totalExpense = FrontExpenses::getTotalExpense($start, $end);

        $csv[2+$x+1]['name'] = 'TOTAL';
        $csv[2+$x+1]['income'] = GlobalHelper::moneyFormat($totalIncome);
        $csv[2+$x+1]['expense'] = GlobalHelper::moneyFormat($totalExpense);
        $margin = $totalIncome - $totalExpense;

        return Excel::create('ProfitLossReport_'.$word, function ($excel) use ($csv) {
            $excel->sheet('ProfitLossReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function expense (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 month'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $filter['department_id'] = ($request->input('department_id')) ? $request->input('department_id') : 0;
        $filter['cash_account_id'] = ($request->input('cash_account_id')) ? $request->input('cash_account_id') : 0;
        $word = date('d_m_Y', strtotime($filter['end']));

        $rows = FrontExpenses::getList($filter, 1000000000);

        $csv = [];

        foreach($rows as $key => $val){
            $csv[$key]['date'] = $val->date;
            $csv[$key]['name'] = Cost::getCostName($val->cost_id);
            $csv[$key]['department'] = Department::getName($val->department_id);
            $csv[$key]['from_account'] = CashAccount::getName($val->cash_account_id);
            $csv[$key]['description'] = $val->desc;
            $csv[$key]['amount'] = GlobalHelper::moneyFormat($val->amount);
        }

        return Excel::create('ExpenseReport_'.$word, function ($excel) use ($csv) {
            $excel->sheet('ProfitLossReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function asset (Request $request){
        if(!UserRole::checkAccess($subModule = 17, $type = 'read')){
            return view("auth.unauthorized");
        }
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $word = date('d_m_Y', strtotime($end));
        $category = ($request->input('category')) ? $request->input('category') : 0;

        $where = [];

        if($category != 0){
            $where[] = ['type', '=', $category];
        }
        $asset = PropertyAttribute::where($where)->get();

        foreach($asset as $key => $value){
            $csv[$key]['name'] = $value->property_attribute_name;
            $csv[$key]['category'] = PropertyAttribute::categoryName($value->type);
            $csv[$key]['purchase_date'] = ($value->purchase_date == null) ? date('j F Y', strtotime($value->created_at)) : date('j F Y', strtotime($value->purchase_date));
            $csv[$key]['purchase_amount'] = GlobalHelper::moneyFormat($value->purchase_amount);
            $csv[$key]['qty'] = $value->qty;
        }

        return Excel::create('AssetReport_'.$word, function ($excel) use ($csv) {
            $excel->sheet('AssetReport', function ($sheet) use ($csv) {
                $sheet->fromArray($csv);
            });
        })->download();

    }
}
