<?php

namespace App\Http\Controllers\Back;

use App\BookingRoom;
use App\OutletTransactionHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index (Request $request)
    {
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');

        $sales = BookingRoom::getRoomSales($start, $end);

        $filter['start'] = $start;
        $filter['end'] = $end;
        $filter['status'] = 3;
        $filter['source'] = 2;

        $filter['delivery_type'] = 1;
        $dine_in = OutletTransactionHeader::getList($filter, $limit = 10000);

        $filter['delivery_type'] = 2;
        $service = OutletTransactionHeader::getList($filter, $limit = 10000);

        $tax_dine = $service_dine = $discount_dine = $bill_dine = 0;
        foreach($dine_in as $key => $value) {
            $tax_dine = $tax_dine + $value->total_tax;
            $service_dine = $service_dine + $value->total_service;
            $discount_dine = $discount_dine + $value->total_discount;
            $bill_dine = $bill_dine + $value->total_billed;
        }

        $tax_service = $service_service = $discount_service = $bill_service = 0;
        foreach($service as $key => $value) {
            $tax_service = $tax_service + $value->total_tax;
            $service_service = $service_service + $value->total_service;
            $discount_service = $discount_service + $value->total_discount;
            $bill_service = $bill_service + $value->total_billed;
        }

        $data = [
            'tax_dine'  => $tax_dine,
            'service_dine'  => $service_dine,
            'discount_dine'  => $discount_dine,
            'bill_dine'  => $bill_dine,
            'tax_service'  => $tax_service,
            'service_service'  => $service_service,
            'discount_service'  => $discount_service,
            'bill_service'  => $bill_service,
            'total_tax'     => $tax_dine + $tax_service,
            'total_service'     => $service_dine + $service_service,
            'total_discount'     => $discount_dine + $discount_service,
            'total_bill'     => $bill_dine + $bill_service,
            'start'     => $start,
            'end'       => $end,
            'room'      => $sales
        ];
        return view('back.dashboard', $data);
    }
}
