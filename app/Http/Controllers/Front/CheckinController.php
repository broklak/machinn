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

    public function __construct()
    {
        $this->middleware('auth');

        $this->module = 'checkin';

        $this->roomPlan = RoomPlan::where('room_plan_status', 1)->get();

        $this->idType = [1 => 'KTP', 2 => 'SIM', 3 => 'PASSPORT'];

        $this->country = Country::where('country_status', 1)->get();

        $this->guest = Guest::paginate(10);

        $this->roomType = RoomType::where('room_type_status', 1)->get();

        $this->floor = PropertyFloor::where('property_floor_status', 1)->get();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['floor'] = $this->floor;
        $data['room_type'] = $this->roomType;
        $data['payment_method'] = config('app.paymentMethod');
        $data['guestModel'] = new Guest();
        $data['guest'] = $this->guest;
        $data['country'] = $this->country;
        $data['religion'] = config('app.religion');
        $data['idType'] = $this->idType;
        $data['plan'] = $this->roomPlan;
        return view("front.".$this->module.".create", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $guest_id = $request->input('guest_id');
        if(!$guest_id){
            $guest = Guest::insertGuest($request->input());
            $guest_id = $guest->guest_id;
        }

        $header = BookingHeader::processHeader($request->input(), $guest_id, $existingId = null, $source = 'checkin');

        BookingRoom::processBookingRoom($request->input(), $header, $source = 'checkin');

        $message = GlobalHelper::setDisplayMessage('success', 'Success to check in');
        return redirect(route("booking.index"))->with('displayMessage', $message);
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function book($bookingId) {
        BookingHeader::find($bookingId)
                        ->update([
                            'booking_status' => 2 // ALREADY CHECKIN
                        ]);

        BookingRoom::where('booking_id', $bookingId)
                        ->update([
                           'status'     => 2
                        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to check in');
        return redirect(route("booking.index"))->with('displayMessage', $message);

    }

}
