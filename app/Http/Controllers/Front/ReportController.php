<?php

namespace App\Http\Controllers\Front;

use App\Report;
use Illuminate\Http\Request;
use App\OutletTransactionHeader;
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
        $this->model = new Report();
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

        $this->parent = 'report-front';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guestBill (Request $request){

        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->guestBill($filter);

        $data['parent_menu'] = $this->parent;
        $data['month_list'] = $this->month;
        $data['year_list'] = self::YEAR_LIMIT;
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        $data['start'] = $start;
        $data['end'] = $end;
        $data['filter'] = $filter;
        $data['rows'] = $report['booking'];
        $data['link'] = $report['link'];
        return view('front.report.guest_bill', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downPayment (Request $request){
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->downPayment($filter);

        $data['parent_menu'] = $this->parent;
        $data['month_list'] = $this->month;
        $data['year_list'] = self::YEAR_LIMIT;
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        $data['start'] = $start;
        $data['end'] = $end;
        $data['filter'] = $filter;
        $data['rows'] = $report;
        return view('front.report.down_payment', $data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function frontPos(Request $request){
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 months'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $filter['bill_number'] = $request->input('bill_number');
        $filter['status'] = $request->input('status');
        $rows = OutletTransactionHeader::getList($filter, config('limitPerPage'));
        $data['parent_menu'] = $this->parent;
        $data['rows'] = $rows;
        $data['filter'] = $filter;
        return view("front.report.pos", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cashCredit (Request $request){
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->downPayment($filter, $down = 4);

        $data['parent_menu'] = $this->parent;
        $data['month_list'] = $this->month;
        $data['year_list'] = self::YEAR_LIMIT;
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        $data['start'] = $start;
        $data['end'] = $end;
        $data['filter'] = $filter;
        $data['rows'] = $report;
        return view('front.report.down_payment', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function source (Request $request){
        $month = ($request->input('month')) ? $request->input('month') : date('m');
        $year = ($request->input('year')) ? $request->input('year') : date('Y');
        $start = date("$year-$month-01");
        $end = date("$year-$month-t");

        $filter['start'] = $start;
        $filter['end'] = $end;
        $report = $this->model->source($filter);

        $data['parent_menu'] = $this->parent;
        $data['month_list'] = $this->month;
        $data['year_list'] = self::YEAR_LIMIT;
        $data['month'] = date('F', strtotime(date("$year-$month-1")));
        $data['year'] = date('Y', strtotime(date("$year-$month-1")));
        $data['start'] = $start;
        $data['end'] = $end;
        $data['filter'] = $filter;
        $data['rows'] = $report;
        return view('front.report.source', $data);
    }

}
