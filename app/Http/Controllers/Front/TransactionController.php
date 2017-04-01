<?php

namespace App\Http\Controllers\Front;

use App\CashAccount;
use App\Cost;
use App\Department;
use App\FrontExpenses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class TransactionController extends Controller
{
    /**
     * @var
     */
    private $model;

    /**
     * @var
     */
    private $module;

    /**
     * @var
     */
    private $cost;

    /**
     * @var
     */
    private $department;

    /**
     * @var
     */
    private $cash;

    public function __construct()
    {
        $this->model = new FrontExpenses();

        $this->module = 'transaction';

        $this->cost = Cost::where('cost_status', 1)->get();

        $this->department = Department::where('department_status', 1)->get();

        $this->cash = CashAccount::where('cash_account_status', 1)->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 month'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $filter['bill_number'] = $request->input('bill_number');
        $filter['status'] = $request->input('status');

        $rows = FrontExpenses::getList($filter, config('limitPerPage'));
        $data['rows'] = $rows;
        $data['filter'] = $filter;
        return view("front.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['cost'] = $this->cost;
        $data['department'] = $this->department;
        $data['cash'] = $this->cash;
        return view("front.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'amount'  => 'required|numeric',
            'cost_id' => 'required',
            'department_id' => 'required',
            'cash_account_id' => 'required',
            'date' => 'required'
        ]);

        $this->model->create([
            'amount'    => $request->input('amount'),
            'desc'    => $request->input('desc'),
            'cost_id'    => $request->input('cost_id'),
            'department_id'    => $request->input('department_id'),
            'cash_account_id'    => $request->input('cash_account_id'),
            'date'    => $request->input('date'),
            'status'    => $request->input('status'),
            'created_by' => Auth::id()
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
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
        $data['cost'] = $this->cost;
        $data['department'] = $this->department;
        $data['cash'] = $this->cash;
        $data['row'] = $this->model->find($id);
        return view("front.".$this->module.".edit", $data);
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
        $this->validate($request,[
            'amount'  => 'required|numeric',
            'cost_id' => 'required',
            'department_id' => 'required',
            'cash_account_id' => 'required',
            'date' => 'required'
        ]);

        $this->model->find($id)->update([
            'amount'    => $request->input('amount'),
            'desc'    => $request->input('desc'),
            'cost_id'    => $request->input('cost_id'),
            'department_id'    => $request->input('department_id'),
            'cash_account_id'    => $request->input('cash_account_id'),
            'date'    => $request->input('date'),
            'status'    => $request->input('status'),
            'updated_by' => Auth::id()
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        $data = $this->model->find($id);

        if($status == 1){
            $action = 'approve';
        } else if($status == 2){
            $action = 'disapprove';
        } else {
            $action = 'delete';
        }

        $data->status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', "Success to $action expenses");
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

}
