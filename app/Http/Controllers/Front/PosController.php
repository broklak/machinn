<?php

namespace App\Http\Controllers\Front;

use App\CashTransaction;
use App\Extracharge;
use App\Guest;
use App\OutletTransactionDetail;
use App\OutletTransactionHeader;
use App\OutletTransactionPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Auth;
use App\Settlement;
use App\CashAccount;
use App\Bank;
use App\CreditCardType;

class PosController extends Controller
{
    /**
     * @var
     */
    private $customer;

    /**
     * @var
     */
    private $items;

    /**
     * @var
     */
    private $module;

    /**
     * @var
     */
    private $settlement;

    /**
     * @var
     */
    private $ccType;

    /**
     * @var
     */
    private $bank;

    /**
     * @var
     */
    private $cash_account;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->settlement = Settlement::where('settlement_status', 1)->get();

        $this->ccType = CreditCardType::where('cc_type_status', 1)->get();

        $this->bank = Bank::where('bank_status', 1)->get();

        $this->cash_account = CashAccount::where('cash_account_status', 1)->get();
        $this->module = 'pos';
        $this->items = Extracharge::where('extracharge_status', 1)->get();
        $this->customer = Guest::all();

        $this->parent = 'cashier';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $data['parent_menu'] = $this->parent;
        $filter['start'] = ($request->input('start')) ? $request->input('start') : date('Y-m-d', strtotime('-1 months'));
        $filter['end'] = ($request->input('end')) ? $request->input('end') : date('Y-m-d');
        $filter['bill_number'] = $request->input('bill_number');
        $filter['status'] = $request->input('status');
        $rows = OutletTransactionHeader::getList($filter, config('limitPerPage'));
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
        $data['parent_menu'] = $this->parent;
        $data['cash_account'] = $this->cash_account;
        $data['cc_type'] = $this->ccType;
        $data['bank']   = $this->bank;
        $data['settlement'] = $this->settlement;
        $data['payment_method'] = config('app.paymentMethod');
        $data['item'] = $this->items;
        $data['guest'] = $this->customer;
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
        $total_price = 0;
        $total_discount = 0;
        $price = $request->input('subtotal');
        $discount = $request->input('discount');
        $qty = $request->input('qty');
        $sub = $request->input('subtotal');
        $type = $request->input('type');

        foreach($price as $key => $value) {
            $total_price  = $total_price + $value;
            $total_discount = $total_discount + $discount[$key];
        }

        $header = OutletTransactionHeader::create([
            'bill_number'   => GlobalHelper::generateBillNumber($request->input('guest_id')),
            'total_billed'  => $total_price,
            'total_discount' => $total_discount,
            'grand_total'   => $request->input('grand_total'),
            'guest_id'      => ($request->input('guest_id')) ? $request->input('guest_id') : 0,
            'date'          => $request->input('date'),
            'status'        => $type,
            'created_by'    => Auth::id()
        ]);

        foreach($price as $key => $value) {
            OutletTransactionDetail::create([
                'transaction_id'    => $header->transaction_id,
                'extracharge_id'    => $key,
                'guest_id'          => $header->guest_id,
                'price'             => $value,
                'qty'               => $qty[$key],
                'discount'          => isset($discount[$key]) ? $discount[$key] : 0,
                'subtotal'          => $sub[$key],
                'status'            => $header->status,
                'created_by'        => Auth::id()
            ]);
        }

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
        return ($type == 2) ? redirect(route($this->module.".edit", ['id' => $header->transaction_id]))->with('displayMessage', $message) : redirect(route($this->module.".index"))->with('displayMessage', $message);
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
        $data['detail'] = OutletTransactionDetail::where('transaction_id', $id)->get();
        $data['payment'] = OutletTransactionPayment::where('transaction_id', $id)->first();
        $data['cash_account'] = $this->cash_account;
        $data['cc_type'] = $this->ccType;
        $data['bank']   = $this->bank;
        $data['settlement'] = $this->settlement;
        $data['payment_method'] = config('app.paymentMethod');
        $data['item'] = $this->items;
        $data['guest'] = $this->customer;
        $data['row'] = OutletTransactionHeader::find($id);
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
        $total_price = 0;
        $total_discount = 0;
        $price = $request->input('subtotal');
        $discount = $request->input('discount');
        $qty = $request->input('qty');
        $sub = $request->input('subtotal');
        $type = $request->input('type');

        if($request->input('payment_method')){
            $type = 3;
        }

        foreach($price as $key => $value) {
            $total_price  = $total_price + $value;
            $total_discount = $total_discount + $discount[$key];
        }

        $header = OutletTransactionHeader::find($id)->update([
            'total_billed'  => $total_price,
            'total_discount' => $total_discount,
            'grand_total'   => $request->input('grand_total'),
            'guest_id'      => ($request->input('guest_id')) ? $request->input('guest_id') : 0,
            'date'          => $request->input('date'),
            'status'        => $type,
            'updated_by'    => Auth::id()
        ]);

        OutletTransactionDetail::where('transaction_id',$id)->delete();

        foreach($price as $key => $value) {
            OutletTransactionDetail::create([
                'transaction_id'    => $id,
                'extracharge_id'    => $key,
                'guest_id'          => ($request->input('guest_id')) ? $request->input('guest_id') : 0,
                'price'             => $value,
                'qty'               => $qty[$key],
                'discount'          => isset($discount[$key]) ? $discount[$key] : 0,
                'subtotal'          => $sub[$key],
                'status'            => $type,
                'created_by'        => Auth::id()
            ]);
        }

        if($type == 3){ // IF PAID
            $created = OutletTransactionPayment::create([
                'transaction_id'     => $id,
                'payment_method'     => $request->input('payment_method'),
                'total_payment'     => $request->input('grand_total'),
                'total_paid'        => $request->input('pay_paid'),
                'total_change'        => (int) $request->input('pay_paid') - (int) $request->input('grand_total'),
                'created_by'        => Auth::id(),
                'guest_id'          => ($request->input('guest_id')) ? $request->input('guest_id') : 0
            ]);

            // INSERT TO CASH TRANSACTION
            $insertCashTransaction = [
                'pos_id'        => $created->id,
                'amount'            => $request->input('grand_total'),
                'desc'              => 'Outlet Posting',
                'cash_account_id'   => $request->input('cash_account_id'),
                'payment_method'    => $request->input('payment_method'),
                'type'              => 2
            ];

            CashTransaction::insert($insertCashTransaction);
        }

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return ($type == 2) ? redirect(route($this->module.".edit", ['id' => $id]))->with('displayMessage', $message) : redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        $data = OutletTransactionHeader::find($id);

        if($status == 2){
            $act = 'void payment';
            OutletTransactionPayment::where('transaction_id', $id)->delete();
        } else {
            $act = 'delete transaction';
        }
        $data->status = $status;

        $data->save();

        OutletTransactionDetail::where('transaction_id', $id)->update([
            'status' => $status
        ]);

        $message = GlobalHelper::setDisplayMessage('success', "Success to $act");
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
