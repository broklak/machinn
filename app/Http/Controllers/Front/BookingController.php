<?php

namespace App\Http\Controllers\Front;

use App\Bank;
use App\BookingHeader;
use App\BookingPayment;
use App\BookingRoom;
use App\CashAccount;
use App\Country;
use App\CreditCardType;
use App\Guest;
use App\Partner;
use App\PropertyFloor;
use App\RoomNumber;
use App\RoomPlan;
use App\RoomRateDateType;
use App\RoomType;
use App\Settlement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

/**
 * Class BookingController
 * @package App\Http\Controllers\Front
 */
class BookingController extends Controller
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
    private $source;

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
    private $settlement;

    /**
     * @var
     */
    private $ccType;

    /**
     * @var
     */
    private $bank;

    /**
     * @var
     */
    private $cash_account;

    /**
     * @var
     */
    private $roomType;

    /**
     * @var
     */
    private $floor;

    public function __construct()
    {
        $this->middleware('auth');

        $this->module = 'booking';

        $this->roomPlan = RoomPlan::where('room_plan_status', 1)->get();

        $this->source = Partner::where('partner_status', 1)->get();

        $this->idType = [1 => 'KTP', 2 => 'SIM', 3 => 'PASSPORT'];

        $this->country = Country::where('country_status', 1)->get();

        $this->guest = Guest::paginate(10);

        $this->settlement = Settlement::where('settlement_status', 1)->get();

        $this->ccType = CreditCardType::where('cc_type_status', 1)->get();

        $this->bank = Bank::where('bank_status', 1)->get();

        $this->cash_account = CashAccount::where('cash_account_status', 1)->get();

        $this->roomType = RoomType::where('room_type_status', 1)->get();

        $this->floor = PropertyFloor::where('property_floor_status', 1)->get();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $filter['guest'] = $request->input('guest');
        $filter['status'] = $request->input('status');
        $getBook = BookingHeader::getBooking($filter);
        $data['filter'] = $filter;
        $data['payment_method'] = config('app.paymentMethod');
        $data['rows'] = $getBook['booking'];
        $data['link'] = $getBook['link'];
        $data['guest_model'] = new Guest();
        return view('front.'.$this->module.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['floor'] = $this->floor;
        $data['room_type'] = $this->roomType;
        $data['cash_account'] = $this->cash_account;
        $data['cc_type'] = $this->ccType;
        $data['bank']   = $this->bank;
        $data['settlement'] = $this->settlement;
        $data['payment_method'] = config('app.paymentMethod');
        $data['guestModel'] = new Guest();
        $data['guest'] = $this->guest;
        $data['country'] = $this->country;
        $data['religion'] = config('app.religion');
        $data['idType'] = $this->idType;
        $data['plan'] = $this->roomPlan;
        $data['source'] = $this->source;
        return view("front.".$this->module.".create", $data);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request){
        $guest_id = $request->input('guest_id');
        if(!$guest_id){
            $guest = $this->insertGuest($request->input());
            $guest_id = $guest->guest_id;
        }

        $header = $this->processHeader($request->input(), $guest_id);

        $this->processBookingRoom($request->input(), $header);

        $this->processPayment($request->input(), $header);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to create new booking');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $header = BookingHeader::find($id);
        $guest_id = $request->input('guest_id');
        if(!$guest_id){
            $guest = $this->insertGuest($request->input());
            $guest_id = $guest->guest_id;
        }

        $this->processHeader($request->input(), $guest_id, $id);

        $this->processBookingRoom($request->input(), $header);

        $this->processPayment($request->input(), $header);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = BookingHeader::getBookingDetail($id);
        $detail->room_data = RoomNumber::getRoomDataList($detail->room_list);
        $data['id'] = $id;
        $data['row'] = $detail;
        $data['floor'] = $this->floor;
        $data['room_type'] = $this->roomType;
        $data['cash_account'] = $this->cash_account;
        $data['cc_type'] = $this->ccType;
        $data['bank']   = $this->bank;
        $data['settlement'] = $this->settlement;
        $data['payment_method'] = config('app.paymentMethod');
        $data['guestModel'] = new Guest();
        $data['guest'] = $this->guest;
        $data['country'] = $this->country;
        $data['religion'] = config('app.religion');
        $data['idType'] = $this->idType;
        $data['plan'] = $this->roomPlan;
        $data['source'] = $this->source;

        return view("front.".$this->module.".edit", $data);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showdownPayment($bookingId){
        $data['header'] = BookingHeader::getBookingDetail($bookingId);
        $data['payment'] = BookingPayment::where('booking_id', $bookingId)->get();
        return view("front.".$this->module.".list_payment", $data);
    }

    /**
     * @param Request $request
     * @param $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function voidBooking(Request $request, $bookingId){
        BookingHeader::find($bookingId)->update([
            'booking_status' => 4,
            'payment_status' => ($request->input('void_type') == 1) ? 4 : 1,
            'updated_by' => Auth::id(),
            'void_reason' => $request->input('void_desc')
        ]);

        BookingRoom::where('booking_id', $bookingId)->update([
            'status' => 8,
            'updated_by' => Auth::id()
        ]);

        if($request->input('void_type') == 1){
            BookingPayment::create([
                'booking_id'    => $bookingId,
                'guest_id'      => $request->input('void_guest_id'),
                'payment_method' => $request->input('void_payment_method'),
                'type'          => 5,
                'total_payment' => $request->input('void_dp_refund'),
                'flow_type'     => 2,
                'created_by'    => Auth::id()
            ]);
        }

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $input
     * @return mixed
     */
    protected function insertGuest($input){
        $guestData = [
            'id_type'       => $input['id_type'],
            'id_number'     => $input['id_number'],
            'type'          => isset($input['guest_type']) ? $input['guest_type'] : 1,
            'title'         => $input['guest_title'],
            'first_name'    => $input['first_name'],
            'last_name'    => $input['last_name'],
            'birthdate'    => $input['birthdate'],
            'birthplace'    => $input['birthplace'],
            'religion'    => isset($input['religion']) ? $input['religion'] : null,
            'gender'    => $input['gender'],
            'job'    => $input['job'],
            'address'    => $input['address'],
            'country_id'    => $input['country_id'],
            'province_id'    => isset($input['province_id']) ? $input['province_id'] : null,
            'homephone'    => $input['homephone'],
            'handphone'    => $input['handphone'],
            'email'    => $input['email'],
            'created_by' => Auth::id()
        ];
        $guest = Guest::create($guestData);
        return $guest;
    }

    /**
     * @param $input
     * @param $guestId
     * @param null $existingId
     * @return array
     */
    protected function processHeader ($input, $guestId, $existingId = null) {
        $room_number = explode(',',$input['room_number']);
        $room_number = array_filter($room_number);

        $bookingHeader = [
            'guest_id'      => $guestId,
            'room_plan_id'  => $input['room_plan_id'],
            'partner_id'  => $input['partner_id'],
            'type'      => $input['type'],
            'room_list' => implode(',', $room_number),
            'checkin_date'      => $input['checkin_date'],
            'checkout_date'      => $input['checkout_date'],
            'adult_num'      => isset($input['adult_num']) ? $input['adult_num'] : 2,
            'grand_total'   => $input['total_rates'],
            'child_num'      => isset($input['child_num']) ? $input['child_num'] : 0,
            'notes'      => $input['notes'],
            'is_banquet'      => $input['is_banquet'],
            'booking_status'      => 1, // 1 NOT CHECKIN YET,
            'payment_status'    => ($input['type'] == 1) ? 2 : 1,
            'created_by'        => Auth::id()
        ];

        if($existingId == null){
            $bookingHeader['booking_code'] = GlobalHelper::generateBookingId($guestId);
        }

        $bookingHeader = ($existingId == null) ? BookingHeader::create($bookingHeader) : BookingHeader::find($existingId)->update($bookingHeader);
        return $bookingHeader;
    }

    /**
     * @param $input
     * @param $header
     * @return int
     */
    protected function processBookingRoom($input, $header) {
        // DELETE FIRST
        BookingRoom::where('booking_id', $header->booking_id)->delete();

        $checkin = strtotime($input['checkin_date']);
        $checkout = strtotime($input['checkout_date']);
        $datediff = floor(abs($checkin - $checkout)) / (60 * 60 * 24);
        $weekdayList = RoomRateDateType::getListDay(1);

        $getRoomPlan = RoomPlan::find($input['room_plan_id']);
        $cost = $getRoomPlan->room_plan_additional_cost;

        for($i = 0;$i < $datediff; $i++){
            $nextDay = $checkin + (86400 * $i);
            $room_number = explode(',',$input['room_number']);
            $room_number = array_filter($room_number);

            foreach($room_number as $val){
                $bookingRoom = [
                    "booking_id"    => $header->booking_id,
                    "guest_id"      => $header->guest_id,
                    "room_number_id" => $val,
                    "room_transaction_date" => date('Y-m-d', $nextDay),
                    "status"        => ($input['type'] == 1) ? 3 : 4,
                    "created_by"    => Auth::id(),
                    "room_plan_rate" => $cost
                ];
                $dayCheckin = date('l', $nextDay);
                if(in_array(strtolower($dayCheckin), $weekdayList)){
                    $bookingRoom['room_rate'] = RoomNumber::getRoomRatesById($val, 1);
                } else {
                    $bookingRoom['room_rate'] = RoomNumber::getRoomRatesById($val, 2);
                }

                BookingRoom::create($bookingRoom);
            }
        }

        return 1;
    }

    /**
     * @param $input
     * @param $header
     * @return int
     */
    protected function processPayment($input, $header) {
        if($input['type'] == 1){ // INSERT DOWN PAYMENT IF GUARANTEED
            $payment = BookingPayment::where('booking_id', $header->booking_id) // CHECK IF DOWNPAYMENT EXIST
                                        ->where('type', 1)
                                        ->first();
            $paymentData = [
                'booking_id'        => $header->booking_id,
                'guest_id'          => $header->guest_id,
                'payment_method'    => isset($input['payment_method']) ? $input['payment_method'] : 1,
                'type'              => 1, // down payment
                'total_payment'     => isset($input['down_payment_amount']) ? $input['down_payment_amount'] : 0,
                'card_type'         => isset($input['card_type']) ? $input['card_type'] : null,
                'card_number'       => $input['card_number'],
                'card_name'         => $input['card_holder'],
                'cc_type_id'        => $input['cc_type'],
                'bank'              => $input['bank'],
                'settlement_id'     => $input['settlement'],
                'card_expiry_month' => (int) substr($input['card_expired_date'], 0, 2),
                'card_expiry_year' => (int) substr($input['card_expired_date'], -4),
                'bank_transfer_recipient' => $input['cash_account_id'],
                'created_by'        => Auth::id()
            ];

            if(count($payment) == 0){
                BookingPayment::create($paymentData);
            } else {
                BookingPayment::find($payment->booking_payment_id)->update($paymentData);
            }
        } else { // DELETE ALL DOWNPAYMENT IF TENTATIVE
            $payment = BookingPayment::where('booking_id', $header->booking_id)
            ->where('type', 1)->delete();
        }
        return 1;
    }
}
