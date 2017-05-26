<?php

namespace App\Http\Controllers\Resto;

use App\OutletTransactionDetail;
use App\OutletTransactionHeader;
use Illuminate\Http\Request;
use App\Report;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    const YEAR_LIMIT = 5;

    private $model;

    private $month;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');
        $this->month = [
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

        $this->model = new Report();

        $this->parent = 'resto-report';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sales (Request $request){
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $filter['start'] = date("$year-$month-01");
        $filter['end'] = date("$year-$month-t");
        $filter['status'] = 3;
        $filter['source'] = 2;
        $filter['delivery_type'] = ($request->input('delivery_type')) ? $request->input('delivery_type') : 0;

        $pos = OutletTransactionHeader::getList($filter, $limit = 1000);

        $data['rows'] = $pos;
        $data['parent_menu'] = $this->parent;
        $data['month_list'] = $this->month;
        $data['numericMonth'] = $month;
        $data['year_list'] = self::YEAR_LIMIT;
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        $data['delivery_type'] = $filter['delivery_type'];
        return view('resto.report.sales', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function item (Request $request){
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $order = $request->input('order');
        $name = $request->input('name');
        $filter['start'] = date("$year-$month-01");
        $filter['end'] = date("$year-$month-t");
        $filter['name'] = $name;

        $pos = OutletTransactionDetail::itemReport($filter, $limit = 1000, $order);

        $data['rows'] = $pos;
        $data['order'] = $order;
        $data['name'] = $name;
        $data['parent_menu'] = $this->parent;
        $data['month_list'] = $this->month;
        $data['numericMonth'] = $month;
        $data['year_list'] = self::YEAR_LIMIT;
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        return view('resto.report.item', $data);
    }
}
