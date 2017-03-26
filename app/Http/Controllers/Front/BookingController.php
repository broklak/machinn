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
    public function index() {
        $getBook = BookingHeader::getBooking();
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

        $insertHeader = $this->insertHeader($request->input(), $guest_id);

        $this->insertBookingRoom($request->input(), $insertHeader);

        $this->insertPayment($request->input(), $insertHeader);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to create new booking');
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
            'type'          => $input['guest_type'],
            'title'         => $input['guest_title'],
            'first_name'    => $input['first_name'],
            'last_name'    => $input['last_name'],
            'birthdate'    => $input['birthdate'],
            'birthplace'    => $input['birthplace'],
            'religion'    => $input['religion'],
            'gender'    => $input['gender'],
            'job'    => $input['job'],
            'address'    => $input['address'],
            'country_id'    => $input['country_id'],
            'province_id'    => $input['province_id'],
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
     * @return array
     */
    protected function insertHeader ($input, $guestId) {
        $bookingHeader = [
            'guest_id'      => $guestId,
            'room_plan_id'  => $input['room_plan_id'],
            'partner_id'  => $input['partner_id'],
            'type'      => $input['type'],
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
        $bookingHeader = BookingHeader::create($bookingHeader);
        return $bookingHeader;
    }

    /**
     * @param $input
     * @param $header
     * @return int
     */
    protected function insertBookingRoom($input, $header) {
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
    protected function insertPayment($input, $header) {
        if($input['type'] == 1){ // INSERT DOWN PAYMENT IF GUARANTEED
            $insertPayment = [
                'booking_id'        => $header->booking_id,
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
            BookingPayment::create($insertPayment);
        }
        return 1;
    }
}
