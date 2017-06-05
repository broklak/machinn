<?php

namespace App\Http\Controllers\Front;

use App\AccountReceivable;
use App\Bank;
use App\BookingDeposit;
use App\BookingExtracharge;
use App\BookingHeader;
use App\BookingPayment;
use App\BookingRoom;
use App\CashAccount;
use App\CashTransaction;
use App\Country;
use App\CreditCardType;
use App\Extracharge;
use App\Guest;
use App\OutletTransactionHeader;
use App\OutletTransactionPayment;
use App\Partner;
use App\PropertyFloor;
use App\RoomNumber;
use App\RoomPlan;
use App\RoomRateDateType;
use App\RoomType;
use App\Settlement;
use App\Tax;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;
use App\Banquet;
use App\BanquetEvent;

class CheckinController extends Controller
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var
     */
    private $roomPlan;

    /**
     * @var
     */
    private $idType;

    /**
     * @var
     */
    private $country;

    /**
     * @var
     */
    private $guest;

    /**
     * @var
     */
    private $roomType;

    /**
     * @var
     */
    private $floor;

    /**
     * @var string
     */
    private $banquet_time;
    /**
     * @var string
     */
    private $banqet_event;

    public function __construct()
    {
        $this->middleware('auth');

        $this->module = 'checkin';

        $this->roomPlan = RoomPlan::where('room_plan_status', 1)->get();

        $this->idType = [1 => 'KTP', 2 => 'SIM', 3 => 'PASSPORT'];

        $this->country = Country::where('country_status', 1)->get();

        $this->guest = Guest::paginate(20);

        $this->roomType = RoomType::where('room_type_status', 1)->get();

        $this->floor = PropertyFloor::where('property_floor_status', 1)->get();

        $this->banquet_time = Banquet::where('banquet_status', 1)->get();

        $this->banqet_event = BanquetEvent::where('event_status', 1)->get();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 6, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = 'room-transaction';
        $data['floor'] = $this->floor;
        $data['room_type'] = $this->roomType;
        $data['payment_method'] = config('app.paymentMethod');
        $data['guestModel'] = new Guest();
        $data['guest'] = $this->guest;
        $data['country'] = $this->country;
        $data['religion'] = config('app.religion');
        $data['idType'] = $this->idType;
        $data['plan'] = $this->roomPlan;
        $data['banquet_time'] = $this->banquet_time;
        $data['banquet_event'] = $this->banqet_event;
        return view("front.".$this->module.".create", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 6, $type = 'create')){
            return view("auth.unauthorized");
        }
        $guest_id = $request->input('guest_id');
        $guest = Guest::insertGuest($request->input(), $guest_id);
        $guest_id = ($guest_id == null) ? $guest->guest_id  : $guest_id;

        $header = BookingHeader::processHeader($request->input(), $guest_id, $existingId = null, $source = 'checkin');

        BookingRoom::processBookingRoom($request->input(), $header, $source = 'checkin');

        $message = GlobalHelper::setDisplayMessage('success', 'Success to check in');
        return redirect(route("guest.inhouse"))->with('displayMessage', $message);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function book($bookingId) {
        if(!UserRole::checkAccess($subModule = 6, $type = 'update')){
            return view("auth.unauthorized");
        }
        BookingHeader::find($bookingId)
                        ->update([
                            'booking_status' => 2 // ALREADY CHECKIN
                        ]);

        BookingRoom::where('booking_id', $bookingId)
                        ->update([
                           'status'     => 2
                        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to check in');
        return redirect(route("checkin.detail", ['id' => $bookingId]))->with('displayMessage', $message);
    }

    /**
     * @param Request $request
     * @param $bookingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail (Request $request,$bookingId){
        if(!UserRole::checkAccess($subModule = 6, $type = 'read')){
            return view("auth.unauthorized");
        }

        $tabActive = ($request->input('tab')) ? $request->input('tab') : 'guest';
        $header = BookingHeader::find($bookingId);
        $header->room_data = RoomNumber::getRoomDataList($header->room_list);

        $guest = Guest::find($header->guest_id);
        $detail = BookingRoom::where('booking_id', $bookingId)->get();
        $payment = BookingPayment::where('booking_id', $bookingId)->get();
        $history = Guest::getHistoryCheckin($header->guest_id);
        $extra = BookingExtracharge::where('booking_id', $bookingId)->get();
        $charge = Extracharge::where('extracharge_status', 1)->get();
        $deposit = BookingDeposit::where('booking_id', $bookingId)->first();

        $data = [
            'tab'       => $tabActive,
            'header'    => $header,
            'deposit'    => $deposit,
            'history'   => $history,
            'guest'     => $guest,
            'detail'    => $detail,
            'payment'   => $payment,
            'extra'     => $extra,
            'idType'    => config('app.guestIdentificationType'),
            'country'   => $this->country,
            'floor'     => PropertyFloor::where('property_floor_status', 1)->get(),
            'room_type' => RoomType::where('room_type_status', 1)->get(),
            'plan'      => RoomPlan::where('room_plan_status', 1)->get(),
            'source'    => Partner::where('partner_status', 1)->get(),
            'religion'  => config('app.religion'),
            'charge'    => $charge
        ];
        $data['parent_menu'] = 'guest';

        return view("front.".$this->module.".detail", $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extracharge(Request $request, $id){
        if(!UserRole::checkAccess($subModule = 8, $type = 'update')){
            return view("auth.unauthorized");
        }
        $room = $request->input('room_id');
        $qty = $request->input('qty');
        $price = $request->input('price');
        $discount = $request->input('discount');
        $subtotal = $request->input('subtotal');

        BookingExtracharge::where('booking_id', $id)->delete();

        if(count($room) > 0){
            foreach ($room as $key => $item) {
                BookingExtracharge::create([
                    'booking_id'    => $id,
                    'guest_id'      => $request->input('guest_id'),
                    'booking_room_id' => $item,
                    'extracharge_id' => $key,
                    'price'         => $price[$key],
                    'qty'           => $qty[$key],
                    'discount'      => isset($discount[$key]) ? $discount[$key] : 0,
                    'total_payment' => $subtotal[$key],
                    'status'        => 1, // BELUM BAYAR,
                    'created_by'    => Auth::id()
                ]);
            }
        }

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save extracharges');
        return redirect(route("checkin.detail", ['id' => $id]).'?tab=extra')->with('displayMessage', $message);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rate(Request $request, $id){
        if(!UserRole::checkAccess($subModule = 8, $type = 'update')){
            return view("auth.unauthorized");
        }
        $room_rate = $request->input('room_rate');
        $plan_rate = $request->input('plan_rate');
        $discount = $request->input('discount');
        $subtotal = $request->input('subtotal');
        $grand_total = $request->input('grand_total');

        foreach ($room_rate as $key => $item) {
            BookingRoom::find($key)->update([
                'room_rate'     => $item,
                'room_plan_rate' => $plan_rate[$key],
                'discount' => $discount[$key],
                'subtotal' => $subtotal[$key],
                'updated_by' => Auth::id()
            ]);
        }

        BookingHeader::find($id)->update([
            'grand_total'   => $grand_total,
            'updated_by'    => Auth::id()
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save rate');
        return redirect(route("checkin.detail", ['id' => $id]).'?tab=rate')->with('displayMessage', $message);
    }

    public function updateRoom (Request $request, $id) {
        if(!UserRole::checkAccess($subModule = 6, $type = 'update')){
            return view("auth.unauthorized");
        }
        $header = BookingHeader::find($id);
        $input = $request->input();
        $room_number_list = explode(',',$input['room_number']);
        $room_number_list = array_filter($room_number_list);
        $room_new = '';

        $checkin = strtotime($input['checkin_date']);
        $checkout = strtotime($input['checkout_date']);
        $datediff = floor(abs($checkin - $checkout)) / (60 * 60 * 24);
        $weekdayList = RoomRateDateType::getListDay(1);

        $getRoomPlan = RoomPlan::find($input['room_plan_id']);
        $cost = $getRoomPlan->room_plan_additional_cost;
        $grand_total = 0;

        // DELETE FIRST
        BookingRoom::where('booking_id', $id)->delete();
        for($i = 0;$i < $datediff; $i++){
            $nextDay = $checkin + (86400 * $i);
            $room_number = explode(',',$input['room_number']);
            $room_number = array_filter($room_number);

            foreach($room_number as $val){
                $bookingRoom = [
                    "booking_id"    => $id,
                    "guest_id"      => $header->guest_id,
                    "room_number_id" => $val,
                    "room_transaction_date" => date('Y-m-d', $nextDay),
                    "status"        => 2,
                    "created_by"    => Auth::id(),
                    "room_plan_rate" => $cost
                ];
                $dayCheckin = date('l', $nextDay);
                if(in_array(strtolower($dayCheckin), $weekdayList)){
                    $rate = RoomNumber::getRoomRatesById($val, 1);
                } else {
                    $rate = RoomNumber::getRoomRatesById($val, 2);
                }
                $bookingRoom['room_rate'] = $rate;
                $bookingRoom['subtotal'] = $rate + $cost;

                BookingRoom::create($bookingRoom);

                $grand_total = $grand_total + $bookingRoom['subtotal'];
                $room_new = $val;
            }
        }

        BookingHeader::find($id)->update([
            'grand_total'   => $grand_total,
            'checkout_date' => $input['checkout_date'],
            'room_plan_id'  => $input['room_plan_id'],
            'partner_id'    => $input['partner_id'],
            'adult_num'     => $input['adult_num'],
            'child_num'     => $input['child_num'],
            'is_banquet'    => $input['is_banquet'],
            'notes'         => $input['notes'],
            'room_list'     => implode(',', $room_number_list),
            'updated_by'    => Auth::id()
        ]);

        BookingExtracharge::where('booking_id', $id)->update([
            'booking_room_id' => $room_new
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save room information');
        return redirect(route("checkin.detail", ['id' => $id]).'?tab=room')->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout ($id) {
        if(!UserRole::checkAccess($subModule = 6, $type = 'update')){
            return view("auth.unauthorized");
        }
        BookingHeader::find($id)->update([
            'checkout'  => 1
        ]);

        BookingRoom::where('booking_id', $id)->update([
            'checkout'  => 1
        ]);

        BookingPayment::where('booking_id',$id)->update([
            'checkout'  => 1
        ]);

        BookingExtracharge::where('booking_id', $id)->update([
            'checkout'  => 1
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to checkout. Proceed to payment now');
        return redirect(route("checkin.payment", ['id' => $id]))->with('displayMessage', $message);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment($bookingId){
        if(!UserRole::checkAccess($subModule = 8, $type = 'update')){
            return view("auth.unauthorized");
        }
        $header = BookingHeader::find($bookingId);
        $header->room_data = RoomNumber::getRoomDataList($header->room_list);
        $header->grand_total = ($header->payment_status == 3) ? 0 : $header->grand_total;

        $guest = Guest::withTrashed()->find($header->guest_id);
        $detail = BookingRoom::where('booking_id', $bookingId)->get();
        $payment = BookingPayment::where('booking_id', $bookingId)->get();
        $history = Guest::getHistoryCheckin($header->guest_id);
        $extra = BookingExtracharge::where('booking_id', $bookingId)->where('status', 1)->get();
        $charge = Extracharge::where('extracharge_status', 1)->get();
        $resto = OutletTransactionHeader::where('booking_id', $bookingId)->where('status', '<>', '3')->get();
        $deposit = BookingDeposit::where('booking_id', $bookingId)->first();

        $refundedDeposit = (isset($deposit->status) && $deposit->status == 1) ? $deposit->refund_amount : 0;
        $total_unpaid_resto = OutletTransactionHeader::getUnpaidResto($bookingId);
        $total_paid = BookingPayment::getTotalPaid($bookingId);
        $total_unpaid_extra = BookingExtracharge::getTotalUnpaid($bookingId);
        $total_unpaid_all = ($header->payment_status == 3) ? 0 : BookingHeader::getTotalUnpaid($header->grand_total, $total_paid, $total_unpaid_extra + $total_unpaid_resto + $refundedDeposit);

        $data = [
            'refundDeposit' => (isset($deposit->status) && $deposit->status == 1) ? true : false,
            'resto'     => $resto,
            'header'    => $header,
            'history'   => $history,
            'guest'     => $guest,
            'detail'    => $detail,
            'payment'   => $payment,
            'extra'     => $extra,
            'charge'    => $charge,
            'bill_number' => GlobalHelper::generateReceipt($bookingId),
            'cash_account' => CashAccount::where('cash_account_status', 1)->where('type', 1)->get(),
            'cc_type'    => CreditCardType::where('cc_type_status', 1)->get(),
            'bank' => Bank::where('bank_status', 1)->get(),
            'settlement' => Settlement::where('settlement_status', 1)->get(),
            'payment_method' => config('app.paymentMethod'),
            'total_unpaid_all'  => $total_unpaid_all,
            'total_unpaid_extra'  => $total_unpaid_extra,
            'total_unpaid_resto'  => $total_unpaid_resto,
            'total_paid'  => $total_paid
        ];

        $data['parent_menu'] = 'guest';

        $data['month'] = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
        $data['year_list'] = 5;

        return view("front.".$this->module.".payment", $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makePayment (Request $request, $id) {
        if(!UserRole::checkAccess($subModule = 8, $type = 'update')){
            return view("auth.unauthorized");
        }
        $header = BookingHeader::find($id);
        BookingHeader::find($id)->update([
            'payment_status'    => 3, // LUNAS
            'updated_by'        => Auth::id(),

        ]);

        BookingExtracharge::where('booking_id', $id)
                            ->where('status', 1)
                            ->update([
                                'status'    => 2,
                                'updated_by' => Auth::id()
                            ]);

        OutletTransactionHeader::where('booking_id', $id)
                                ->update([
                                   'status'     => 3,
                                    'updated_by' => Auth::id()
                                ]);

        $resto = OutletTransactionHeader::where('booking_id', $id)->get();

        foreach($resto as $key => $val){
            OutletTransactionPayment::create([
                'transaction_id'    => $val->transaction_id,
                'payment_method'    => $request->input('payment_method'),
                'total_payment'     => $val->grand_total,
                'total_paid'        => $val->grand_total,
                'total_change'      => 0,
                'card_number'        => $request->input('card_number'),
                'card_type'        => $request->input('card_type'),
                'settlement_id'     => null,
                'cc_type_id'        => $request->input('cc_type'),
                'cc_holder'        => $request->input('card_holder'),
                'bank'              => $request->input('bank'),
                'guest_id'          => $request->input('guest_id'),
                'card_expiry_month' => $request->input('month'),
                'card_expiry_year' => $request->input('year'),
                'bank_transfer_recipient'  => ($request->input('cash_account_id') != 0) ? $request->input('cash_account_id') : null ,
                'created_by'        => Auth::id()
            ]);
        }

        BookingPayment::create([
            'booking_id'        => $id,
            'payment_method'    => $request->input('payment_method'),
            'checkout'          => 1,
            'type'              => 4, // PELUNASAN
            'total_payment'     => $request->input('total_unpaid'),
            'guest_id'          => $request->input('guest_id'),
            'settlement_id'        => $request->input('settlement'),
            'cc_type_id'        => $request->input('cc_type'),
            'bank'              => $request->input('bank'),
            'bank_transfer_recipient'  => ($request->input('cash_account_id') != 0) ? $request->input('cash_account_id') : null ,
            'card_type'        => $request->input('card_type'),
            'card_number'        => $request->input('card_number'),
            'card_name'        => $request->input('card_holder'),
            'card_expiry_month' => $request->input('month'),
            'card_expiry_year' => $request->input('year'),
            'created_by'        => Auth::id()
        ]);

        // INSERT TO ACCOUNT RECEIVABLE
        $insertAccReceivable = [
            'booking_id'    => $id,
            'date'    => date('Y-m-d'),
            'amount'    => $request->input('total_unpaid'),
            'desc'      => 'Final Payment Booking '.$header->booking_code,
            'partner_id' => $header->partner_id,
            'paid'      => 0,
            'created_by' => Auth::id()
        ];
        AccountReceivable::insert($insertAccReceivable);

        // INSERT TO CASH TRANSACTION
        $insertCashTransaction = [
            'booking_id'        => $id,
            'amount'            => $request->input('total_unpaid'),
            'desc'              => 'Final Payment Booking '.$header->booking_code,
            'cash_account_id'   => $request->input('cash_account_id'),
            'payment_method'    => $request->input('payment_method'),
            'type'              => 2
        ];

        CashTransaction::insert($insertCashTransaction);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to make payment');
        return redirect(route("checkin.payment", ['id' => $id]))->with('displayMessage', $message);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printReceipt($bookingId){
        if(!UserRole::checkAccess($subModule = 8, $type = 'read')){
            return view("auth.unauthorized");
        }
        $header = BookingHeader::find($bookingId);
        $guest = Guest::withTrashed()->find($header->guest_id);
        $payment = BookingPayment::where('booking_id', $bookingId)->where('deposit', 0)->where('type', '<>', '5')->get();

        $total = 0;
        foreach($payment as $key => $value){
            $total = $total + $value->total_payment;
        }
        $created = ($header->updated_by) ? User::getName($header->updated_by) : User::getName($header->created_by);

        $data = [
            'name'  => $guest->first_name.' '.$guest->last_name,
            'admin' => $created,
            'header' => $header,
            'bill_number' => GlobalHelper::generateReceipt($bookingId),
            'total' => GlobalHelper::moneyFormat($total),
            'date'  => date('l, j F Y'),
            'created_at'  => date('j-F-Y H:i:s'),
            'hotel_name'   => session('name'),
            'hotel_phone'   => session('phone'),
            'hotel_fax'   => session('fax'),
            'hotel_email'   => session('email'),
            'hotel_address'   => session('address')
        ];

        return view("print.receipt", $data);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printBill($bookingId){
        if(!UserRole::checkAccess($subModule = 8, $type = 'read')){
            return view("auth.unauthorized");
        }
        $header = BookingHeader::find($bookingId);
        $guest = Guest::withTrashed()->find($header->guest_id);
        $downpayment = BookingPayment::where('booking_id', $bookingId)->where('type', 1)->get();
        $final_payment = BookingPayment::where('booking_id', $bookingId)->where('type', 4)->get();
        $refund = BookingPayment::where('booking_id', $bookingId)->where('type', 5)->get();
        $extrachargePaid = BookingPayment::where('booking_id', $bookingId)->where('type', 3)->get();
        $extracharge = BookingExtracharge::where('booking_id', $bookingId)->get();
        $total_resto = OutletTransactionHeader::getRestoBill($bookingId);
        $created = ($header->updated_by) ? User::getName($header->updated_by) : User::getName($header->created_by);

        $total = 0;
        foreach($extracharge as $key => $value){
            $total = $total + $value->total_payment;
        }

        $total_paid = 0;
        foreach($extrachargePaid as $key => $value){
            $total_paid = $total_paid + $value->total_payment;
        }

        $total_dp = 0;
        foreach($downpayment as $key => $value){
            $total_dp = $total_dp + $value->total_payment;
        }

        $total_refund = 0;
        foreach($refund as $key => $value){
            $total_refund = $total_refund + $value->total_payment;
        }

        $total_final = 0;
        foreach($final_payment as $key => $value){
            $total_final = $total_final + $value->total_payment;
        }

        $tax = Tax::find(1);
        $service = Tax::find(2);

        $data = [
            'name'  => Guest::getTitleName($guest->title). ' '.$guest->first_name.' '.$guest->last_name,
            'admin' => $created,
            'total_resto' => $total_resto,
            'header' => $header,
            'extracharge' => $total,
            'total_room' => $header->grand_total,
            'total_extra' => $total,
            'total_refund' => $total_refund,
            'total_extra_paid' => $total_paid,
            'total_dp' => $total_dp,
            'tax' => $tax->tax_percentage,
            'service' => $service->tax_percentage,
            'total_final_paid' => $total_final,
            'total_debit' => $header->grand_total + $total + $total_resto,
            'total_credit' => $total_dp + $total_paid + $total_final + $total_refund,
            'total_balance' => ($header->grand_total + $total + $total_resto) - ($total_dp + $total_paid + $total_final),
            'bill_number' => GlobalHelper::generateReceipt($bookingId),
            'total' => GlobalHelper::moneyFormat($total),
            'date'  => date('l, j F Y'),
            'created_at'  => date('j-F-Y H:i:s'),
            'hotel_name'   => session('name'),
            'hotel_phone'   => session('phone'),
            'hotel_fax'   => session('fax'),
            'hotel_email'   => session('email'),
            'hotel_address'   => session('address')
        ];

        return view("print.bill", $data);
    }

    /**
     * @param Request $request
     * @param $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deposit(Request $request, $bookingId){
        $bookingData = BookingHeader::find($bookingId);
        $amount = str_replace(',', '', $request->input('amount'));

        // INSERT TO BOOKING PAYMENT FIRST
        BookingPayment::create([
            'booking_id'    => $bookingId,
            'guest_id'      => $bookingData->guest_id,
            'type'          => 10,
            'payment_method' => 1, // DEPOSIT MUST BE CASH PAID TO FRONT OFFICE,
            'total_payment' => $amount,
            'deposit'       => 1,
            'created_by'    => Auth::id()
        ]);

        // INSERT TO CASH TRANSACTION
        CashTransaction::insert([
            'booking_id'        => $bookingId,
            'amount'            => $amount,
            'desc'              => 'Check In Deposit',
            'payment_method'    => 1,
            'type'              => 2
        ]);

        BookingDeposit::create([
            'booking_id'    => $bookingId,
            'amount'        => $amount,
            'created_by'    => Auth::id()
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save deposit.');
        return redirect(route("checkin.detail", ['id' => $bookingId]).'?tab=bill')->with('displayMessage', $message);
    }

    /**
     * @param $bookingPaymentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function voidDeposit ($bookingPaymentId){
        $bookingPayment = BookingPayment::find($bookingPaymentId);

        BookingDeposit::where('booking_id', $bookingPayment->booking_id)->delete();

        // INSERT TO CASH TRANSACTION
        CashTransaction::insert([
            'booking_id'        => $bookingPayment->booking_id,
            'amount'            => $bookingPayment->total_payment,
            'desc'              => 'Void Deposit',
            'payment_method'    => 1,
            'type'              => 1
        ]);

        $bookingPayment->delete();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to void deposit.');
        return redirect(route("checkin.detail", ['id' => $bookingPayment->booking_id]).'?tab=bill')->with('displayMessage', $message);
    }

    /**
     * @param $bookingPaymentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refundDeposit (Request $request,$bookingPaymentId){
        $bookingPayment = BookingPayment::find($bookingPaymentId);
        $refund_amount = str_replace(',', '', $request->input('refund_amount'));
        $total_deposit = $request->input('total_deposit');

        BookingDeposit::where('booking_id', $bookingPayment->booking_id)
            ->update([
                'refund_amount' => $refund_amount,
                'desc'          => $request->input('desc'),
                'status'    => 1,
                'updated_by' => Auth::id()
        ]);

        // INSERT TO CASH TRANSACTION
        CashTransaction::insert([
            'booking_id'        => $bookingPayment->booking_id,
            'amount'            => $refund_amount,
            'desc'              => 'Refund Deposit '.$request->input('desc'),
            'payment_method'    => 1,
            'type'              => 1
        ]);

        // IF REFUND IS NOT SAME AS DEPOSIT
        if((int) $refund_amount != (int) $total_deposit ){
            BookingPayment::create([
                'booking_id'    => $bookingPayment->booking_id,
                'guest_id'      => $bookingPayment->guest_id,
                'type'          => 5,
                'payment_method' => 1, // DEPOSIT MUST BE CASH PAID TO FRONT OFFICE,
                'total_payment' => $total_deposit - $refund_amount,
                'created_by'    => Auth::id()
            ]);
        }

        $message = GlobalHelper::setDisplayMessage('success', 'Success to refund deposit.');
        return redirect(route("checkin.payment", ['id' => $bookingPayment->booking_id]))->with('displayMessage', $message);
    }

    /**
     * @param $bookingPaymentId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printDeposit($bookingPaymentId){
        if(!UserRole::checkAccess($subModule = 8, $type = 'read')){
            return view("auth.unauthorized");
        }

        $payment = BookingPayment::find($bookingPaymentId);
        $guest = Guest::withTrashed()->find($payment->guest_id);
        $header = BookingHeader::find($payment->booking_id);

        $total = $payment->total_payment;
        $created = ($header->updated_by) ? User::getName($header->updated_by) : User::getName($header->created_by);

        $data = [
            'deposit'   => 1,
            'name'  => $guest->first_name.' '.$guest->last_name,
            'admin' => $created,
            'header' => $header,
            'bill_number' => GlobalHelper::generateReceipt($bookingPaymentId, $deposit = true),
            'total' => GlobalHelper::moneyFormat($total),
            'date'  => date('l, j F Y'),
            'created_at'  => date('j-F-Y H:i:s'),
            'hotel_name'   => session('name'),
            'hotel_phone'   => session('phone'),
            'hotel_fax'   => session('fax'),
            'hotel_email'   => session('email'),
            'hotel_address'   => session('address')
        ];

        return view("print.receipt", $data);
    }

}
