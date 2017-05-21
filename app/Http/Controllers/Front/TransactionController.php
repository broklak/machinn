<?php

namespace App\Http\Controllers\Front;

use App\CashAccount;
use App\CashTransaction;
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

    /**
     * @var string
     */
    private $parent;

    /**
     * @var string
     */
    private $url;

    public function __construct()
    {
        $this->model = new FrontExpenses();

        $this->module = 'transaction';

        $this->url = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.' : '';

        $this->cost = Cost::where('cost_status', 1)->get();

        $this->department = Department::where('department_status', 1)->get();

        $this->cash = CashAccount::where('cash_account_status', 1)->get();

        $this->parent = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back-transaction' : 'cashier';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 month'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d', strtotime('+1 month'));
        $filter['bill_number'] = $request->input('bill_number');
        $filter['status'] = $request->input('status');

        $rows = FrontExpenses::getList($filter, config('limitPerPage'));
        $data['rows'] = $rows;
        $data['parent_menu'] = $this->parent;
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
        $data['parent_menu'] = $this->parent;
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

        $created = $this->model->create([
            'amount'    => $request->input('amount'),
            'desc'    => $request->input('desc'),
            'cost_id'    => $request->input('cost_id'),
            'department_id'    => $request->input('department_id'),
            'cash_account_id'    => $request->input('cash_account_id'),
            'date'    => $request->input('date'),
            'status'    => 2, // NOT APPROVED
            'created_by' => Auth::id()
        ]);

        // INSERT TO CASH TRANSACTION
        $insertCashTransaction = [
            'expense_id'        => $created->id,
            'amount'            => $request->input('amount'),
            'desc'              => Cost::getCostName($request->input('cost_id')),
            'cash_account_id'   => $request->input('cash_account_id'),
            'payment_method'    => 4,
            'type'              => 1
        ];

        CashTransaction::insert($insertCashTransaction);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
        return redirect(route($this->url.$this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['parent_menu'] = $this->parent;
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
            'updated_by' => Auth::id()
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->url.$this->module.".index"))->with('displayMessage', $message);
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
        return redirect(route($this->url.$this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', 'Success to delete data');
        return redirect(route($this->url.$this->module.".index"))->with('displayMessage', $message);
    }
}
