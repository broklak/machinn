<?php

namespace App\Http\Controllers\Back;

use App\CashAccount;
use App\Invoice;
use App\InvoicePayment;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class InvoicePaymentController extends Controller
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
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new InvoicePayment();

        $this->module = 'invoice-payment';

        $this->parent = 'invoice';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 15, $type = 'update')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $status = ($request->input('status')) ? $request->input('status') : 0;
        $data['parent_menu'] = $this->parent;
        $data['status'] = $status;
        $data['start'] = $start;
        $data['end'] = $end;
        $rows = $this->model->getInvoicePayment($start, $end, $status);
        $data['rows'] = $rows;
        return view("back.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 15, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['cash_account'] = CashAccount::all();
        $data['invoice'] = Invoice::where('paid', 0)->get();
        $data['parent_menu'] = $this->parent;
        return view("back.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 15, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'payment_date'  => 'required',
            'invoice_id'  => 'required',
            'paid_amount'  => 'required',
            'cash_account_id'  => 'required',
        ]);

        Invoice::find($request->input('invoice_id'))->update([
            'paid'  => 1
        ]);

        $this->model->create([
            'invoice_id'      => $request->input('invoice_id'),
            'payment_date'      => $request->input('payment_date'),
            'paid_amount'      => $request->input('paid_amount'),
            'desc'      => $request->input('description'),
            'cash_account_id'      => $request->input('cash_account_id'),
            'created_by'      => Auth::id(),
            'status'        => 0
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!UserRole::checkAccess($subModule = 15, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['invoice'] = Invoice::where('paid', 0)->get();
        $data['parent_menu'] = $this->parent;
        $data['row'] = $this->model->find($id);
        return view("back.".$this->module.".edit", $data);
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
        if(!UserRole::checkAccess($subModule = 15, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'payment_date'  => 'required',
            'invoice_id'  => 'required',
            'paid_amount'  => 'required',
            'cash_account_id'  => 'required',
        ]);

        $data = $this->model->find($id)->update([
            'invoice_id'      => $request->input('invoice_id'),
            'payment_date'      => $request->input('payment_date'),
            'paid_amount'      => $request->input('paid_amount'),
            'desc'      => $request->input('description'),
            'cash_account_id'      => $request->input('cash_account_id'),
            'updated_by'      => Auth::id(),
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        if(!UserRole::checkAccess($subModule = 15, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $invoice = $data->invoice_id;

        Invoice::find($invoice)->update([
            'paid'  => $active
        ]);

        $data->status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 15, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', 'Success to delete data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
