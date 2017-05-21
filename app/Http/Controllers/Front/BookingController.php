<?php

namespace App\Http\Controllers\Front;

use App\Bank;
use App\Banquet;
use App\BanquetEvent;
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
use Illuminate\Support\Facades\DB;

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

    /**
     * @var string
     */
    private $parent;

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

        $this->module = 'booking';

        $this->roomPlan = RoomPlan::where('room_plan_status', 1)->get();

        $this->source = Partner::where('partner_status', 1)->get();

        $this->idType = config('app.guestIdentificationType');

        $this->country = Country::where('country_status', 1)->get();

        $this->guest = Guest::paginate(10);

        $this->settlement = Settlement::where('settlement_status', 1)->get();

        $this->ccType = CreditCardType::where('cc_type_status', 1)->get();

        $this->bank = Bank::where('bank_status', 1)->get();

        $this->cash_account = CashAccount::where('cash_account_status', 1)->where('type', 1)->get();

        $this->roomType = RoomType::where('room_type_status', 1)->get();

        $this->floor = PropertyFloor::where('property_floor_status', 1)->get();

        $this->banquet_time = Banquet::where('banquet_status', 1)->get();

        $this->banqet_event = BanquetEvent::where('event_status', 1)->get();

        $this->parent = 'room-transaction';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $type = $request->input('type');
        $data['parent_menu'] = $this->parent;
        if($type == 'housekeep'){
            $data['parent_menu'] = 'booking-house';
        }
        $filter['guest'] = $request->input('guest');
        $filter['status'] = $request->input('status');
        $getBook = BookingHeader::getBooking($filter);
        $data['type'] = $type;
        $data['filter'] = $filter;
        $data['payment_method'] = config('app.paymentMethod');
        $data['rows'] = $getBook['booking'];
        $data['link'] = $getBook['link'];
        $data['guest_model'] = new Guest();
        return view('front.'.$this->module.'.index', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $data['parent_menu'] = $this->parent;
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
        $data['banquet_time'] = $this->banquet_time;
        $data['banquet_event'] = $this->banqet_event;
        return view("front.".$this->module.".create", $data);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request){
        $guest_id = $request->input('guest_id');
        $guest = Guest::insertGuest($request->input(), $guest_id);
        $guest_id = ($guest_id == null) ? $guest->guest_id  : $guest_id;

        $header = BookingHeader::processHeader($request->input(), $guest_id);

        BookingRoom::processBookingRoom($request->input(), $header);

        BookingPayment::processPayment($request->input(), $header);

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
        $guest = Guest::insertGuest($request->input(), $guest_id);
        $guest_id = ($guest_id == null) ? $guest->guest_id  : $guest_id;

        BookingHeader::processHeader($request->input(), $guest_id, $id);

        BookingRoom::processBookingRoom($request->input(), $header);

        BookingPayment::processPayment($request->input(), $header);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $data['parent_menu'] = $this->parent;
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
        $data['banquet_time'] = $this->banquet_time;
        $data['banquet_event'] = $this->banqet_event;
        return view("front.".$this->module.".edit", $data);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showdownPayment($bookingId){
        $data['parent_menu'] = $this->parent;
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report(Request $request){
        $data['parent_menu'] = 'report-front';
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $data['partner'] = Partner::all();
        $data['month_list'] = [
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
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        $data['start'] = $start;
        $data['end'] = $end;

        $data['bookActiveNum'] = BookingHeader::where('booking_status', 1)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->count();
        $data['bookCheckinNum'] = BookingHeader::where('booking_status', 2)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->count();
        $data['bookNoShowNum'] = BookingHeader::where('booking_status', 3)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->count();
        $data['bookVoidNum'] = BookingHeader::where('booking_status', 4)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->count();

        $data['activeRoomNum'] = BookingRoom::select(DB::raw('distinct(room_number_id)'))->whereIn('status', [3,4])->whereBetween('room_transaction_date', [$start, $end])->get();
        $data['voidRoomNum'] = BookingRoom::select(DB::raw('distinct(room_number_id)'))->where('status', 8)->whereBetween('room_transaction_date', [$start, $end])->get();
        $data['noShowRoomNum'] = BookingRoom::select(DB::raw('distinct(room_number_id)'))->where('status', 7)->whereBetween('room_transaction_date', [$start, $end])->get();
        $data['checkInRoomNum'] = BookingRoom::select(DB::raw('distinct(room_number_id)'))->where('status', 2)->whereBetween('room_transaction_date', [$start, $end])->get();

        $data['activeNightNum'] = BookingHeader::select(DB::raw('SUM(DAY(checkout_date) - DAY(checkin_date)) as total_night'))->where('booking_status', 1)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->value('total_night');
        $data['checkInNightNum'] = BookingHeader::select(DB::raw('SUM(DAY(checkout_date) - DAY(checkin_date)) as total_night'))->where('booking_status', 2)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->value('total_night');
        $data['noShowNightNum'] = BookingHeader::select(DB::raw('SUM(DAY(checkout_date) - DAY(checkin_date)) as total_night'))->where('booking_status', 3)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->value('total_night');
        $data['voidNightNum'] = BookingHeader::select(DB::raw('SUM(DAY(checkout_date) - DAY(checkin_date)) as total_night'))->where('booking_status', 4)->where('partner_id', '<>', 0)->whereBetween('checkin_date', [$start, $end])->value('total_night');

        $data['bookActiveList'] = BookingHeader::getBookingReport($status = 1);
        $data['bookCheckInList'] = BookingHeader::getBookingReport($status = 2);
        $data['bookNoShowList'] = BookingHeader::getBookingReport($status = 3);
        $data['bookVoidList'] = BookingHeader::getBookingReport($status = 4);
        return view("front.".$this->module.".report", $data);
    }
}
