<?php

namespace App\Http\Controllers\Front;

use App\Extracharge;
use App\Helpers\GlobalHelper;
use App\Province;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Guest;
use App\RoomNumber;
use App\RoomRateDateType;
use Illuminate\Support\Facades\Cache;

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
        $booking_id = $request->input('booking_id');
        $filter['type'] = $request->input('type');
        $filter['floor'] = $request->input('floor');
        $filter['banquet'] = $request->input('banquet');

        $getRoom = RoomNumber::getRoomAvailable($checkin, $checkout, $filter);
        $mod = [];

        foreach($getRoom as $key => $val){
            $mod[$val->room_type_name]['weekends_rate'] = $val->room_rate_weekends;
            $mod[$val->room_type_name]['weekdays_rate'] = $val->room_rate_weekdays;
            $mod[$val->room_type_name]['floor'][$val->property_floor_name][] = (array)$val;
        }

        $html = GlobalHelper::generateHTMLRoomChoice($mod, $booking_id);

        return $html;
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

    /**
     * @return string
     */
    public function getLookBook () {
        $data = Cache::get('logbook');
        $log = [];
        foreach($data as $key => $val){
            $log[] = [
                'title' => '<a style="color:#fff" href="'.route('logbook.index').'">Message from '.User::getName($val['created_by']).'</a>',
                'text' => '<a style="color:#fff" href="'.route('logbook.index').'">'.$val['logbook_message'].'</a>'
            ];
        }
        return json_encode($log);
    }
}
