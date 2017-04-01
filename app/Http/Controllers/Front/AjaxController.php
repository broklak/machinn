<?php

namespace App\Http\Controllers\Front;

use App\Extracharge;
use App\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Guest;
use App\RoomNumber;
use App\RoomRateDateType;

class AjaxController extends Controller
{

    /**
     * @param Request $request
     * @return array|string
     */
    public function searchGuest(Request $request){
        $filter = $request->input('query');

        $getGuest = Guest::where('first_name', 'LIKE', "%$filter%")
            ->orWhere('last_name', 'LIKE', "%$filter%")
            ->orWhere('id_number', 'LIKE', "%$filter%")
            ->get();

        return json_encode($getGuest);
    }

    /**
     * @param Request $request
     * @return array|string
     */
    public function searchItem(Request $request){
        $filter = $request->input('query');

        $getGuest = Extracharge::where('extracharge_name', 'LIKE', "%$filter%")
            ->get();

        return json_encode($getGuest);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function searchProvince (Request $request) {
        $country = $request->input('country');

        $getProvince = Province::where('country_id', $country)->get();

        return json_encode($getProvince);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function searchRoom (Request $request) {
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $filter['type'] = $request->input('type');
        $filter['floor'] = $request->input('floor');

        $getRoom = RoomNumber::getRoomAvailable($checkin, $checkout, $filter);

        return json_encode($getRoom);
    }

    /**
     * @param Request $request
     * @return int
     */
    public function getTotalRoomRates(Request $request) {
        $subtotal = 0;
        $action = $request->input('action');
        $checkin = strtotime($request->input('checkin'));
        $checkout = strtotime($request->input('checkout'));
        $rateWeekdays = (int) $request->input('rateWeekdays');
        $rateWeekends = (int) $request->input('rateWeekends');
        $totalRates = ($request->input('totalRates')) ? (int) $request->input('totalRates') : 0;
        $weekdayList = RoomRateDateType::getListDay(1);
        $datediff = floor(abs($checkin - $checkout)) / (60 * 60 * 24);

        for($i = 0;$i < $datediff; $i++){
            $dayCheckin = date('l', $checkin + (86400 * $i));
            if(in_array(strtolower($dayCheckin), $weekdayList)){
                $subtotal = $subtotal + $rateWeekdays;
            } else {
                $subtotal = $subtotal + $rateWeekends;
            }
        }

        $data['total_rates'] = ($action == 'plus') ? $totalRates + $subtotal : $totalRates - $subtotal;
        $data['subtotal_room'] = $subtotal;
        return json_encode($data);
    }
}
