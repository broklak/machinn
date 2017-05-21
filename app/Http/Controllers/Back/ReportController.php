<?php

namespace App\Http\Controllers\Back;

use App\BookingExtracharge;
use App\BookingPayment;
use App\BookingRoom;
use App\CashAccount;
use App\CashTransaction;
use App\Department;
use App\Extracharge;
use App\FrontExpenses;
use App\OutletTransactionPayment;
use App\PropertyAttribute;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    const YEAR_LIMIT = 5;

    private $month;

    /**
     * @var string
     */
    private $parent;

    /**
     * @var
     */
    private $module;

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

        $this->module = 'report';

        $this->parent = 'back-report';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cash (Request $request){
        $type = ($request->input('type')) ? $request->input('type') : 'balance';
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $account = ($request->input('cash_account_id')) ? $request->input('cash_account_id') : 0;
        $data['parent_menu'] = $this->parent;
        $balance = CashAccount::all();
        $transaction = CashTransaction::getTransaction($start, $end, $account);
        $data['balance'] = $balance;
        $data['transaction'] = $transaction;
        $data['account'] = $account;
        $data['start'] = $start;
        $data['end'] = $end;
        $data['type'] = $type;
        return view("back.".$this->module.".cash", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profit(Request $request){
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');

        $roomIncome = BookingPayment::getIncome($start, $end);
        $restoIncome = OutletTransactionPayment::getIncome($start, $end);
        $extraIncome = BookingExtracharge::getIncome($start, $end);

        $expenses = FrontExpenses::getExpensesByCost($start, $end);
        $totalExpense = FrontExpenses::getTotalExpense($start, $end);
        $data = [
            'start'         => $start,
            'end'           => $end,
            'roomIncome'    => $roomIncome,
            'restoIncome'    => $restoIncome,
            'extraIncome'    => $extraIncome,
            'totalIncome'   => $restoIncome + $roomIncome + $extraIncome,
            'expenses'      => $expenses,
            'totalExpense'  => $totalExpense,
            'parent_menu'   => $this->parent
        ];

        return view("back.".$this->module.".profit", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function expense (Request $request){
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 month'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $filter['department_id'] = ($request->input('department_id')) ? $request->input('department_id') : 0;
        $filter['cash_account_id'] = ($request->input('cash_account_id')) ? $request->input('cash_account_id') : 0;

        $rows = FrontExpenses::getList($filter, config('limitPerPage'));
        $data['rows'] = $rows;
        $data['parent_menu'] = $this->parent;
        $data['filter'] = $filter;
        $data['department'] = Department::all();
        $data['cash_account'] = CashAccount::all();
        return view("back.".$this->module.".expense", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function asset (Request $request){
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $category = ($request->input('category')) ? $request->input('category') : 0;

        $where = [];

        if($category != 0){
            $where[] = ['type', '=', $category];
        }
        $asset = PropertyAttribute::where($where)->get();

        $data = [
            'start'         => $start,
            'end'           => $end,
            'asset'         => $asset,
            'category'      => $category,
            'parent_menu'   => $this->parent
        ];
        return view("back.".$this->module.".asset", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trial (Request $request){
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');

        $data = [
            'start'         => $start,
            'end'           => $end,
            'parent_menu'   => $this->parent
        ];
        return view("back.".$this->module.".trial", $data);
    }
}
