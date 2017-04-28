<?php

namespace App\Http\Controllers\Resto;

use App\BookingHeader;
use App\Extracharge;
use App\Guest;
use App\OutletTransactionDetail;
use App\OutletTransactionHeader;
use App\OutletTransactionPayment;
use App\PosItem;
use App\PosTable;
use App\PosTax;
use App\User;
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
        $this->module = 'resto.pos';
        $this->items = PosItem::where('status', 1)->get();
        $this->customer = Guest::getInhouseGuestWithRoom();

        $this->parent = 'pos-resto';
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
        $filter['delivery_type'] = $request->input('delivery_type');
        $filter['source'] = 2;
        $rows = OutletTransactionHeader::getList($filter, config('limitPerPage'));
        $data['rows'] = $rows;
        $data['filter'] = $filter;
        return view($this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['table'] = PosTable::all();
        $data['waiters'] = User::where('department_id', 4)->get();
        $data['parent_menu'] = $this->parent;
        $data['cash_account'] = $this->cash_account;
        $data['cc_type'] = $this->ccType;
        $data['bank']   = $this->bank;
        $data['settlement'] = $this->settlement;
        $data['payment_method'] = config('app.paymentMethod');
        $data['item'] = $this->items;
        $data['guest'] = $this->customer;
        return view($this->module.".create", $data);
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
        $grand_total = $request->input('grand_total');

        $tax = PosTax::getTax($grand_total);
        $service = PosTax::getService($grand_total);

        foreach($price as $key => $value) {
            $total_price  = $total_price + $value;
            $total_discount = $total_discount + $discount[$key];
        }

        $getTable = PosTable::where('name', $request->input('table_id'))->first();

        $header = OutletTransactionHeader::create([
            'bill_number'   => GlobalHelper::generateBillNumber($request->input('guest_id')),
            'total_billed'  => $total_price,
            'total_discount' => $total_discount,
            'total_tax'     => $tax,
            'booking_id'    => $request->input('booking_id'),
            'total_service' => $service,
            'grand_total'   => $grand_total + $tax + $service,
            'guest_id'      => ($request->input('guest_id')) ? $request->input('guest_id') : 0,
            'date'          => $request->input('date'),
            'status'        => $type,
            'created_by'    => Auth::id(),
            'waiters'       => $request->input('waiters'),
            'guest_num'     => ($request->input('guest_num')) ? $request->input('guest_num') : 2,
            'table_id'      => isset($getTable->id) ? $getTable->id : 0,
            'room_id'       => $request->input('room_id'),
            'bill_type'     => $request->input('bill_type'),
            'delivery_type' => $request->input('delivery_type'),
            'source'        => 2 // RESTO
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
                'created_by'        => Auth::id(),
                'delivery_status'   => 0
            ]);

            $item = PosItem::find($key);
            $qty_old = $item->stock;
            $item->stock = $qty_old - $qty[$key];
            $item->save();
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
        $data['month'] = [
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
        $data['year_list'] = 5;
        $data['table'] = PosTable::all();
        $data['waiters'] = User::where('department_id', 4)->get();
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
        return view($this->module.".edit", $data);
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
        $grand_total = $total_price - $total_discount;
        $tax = PosTax::getTax($grand_total);
        $service = PosTax::getService($grand_total);

        $getTable = PosTable::where('name', $request->input('table_id'))->first();

        $header = OutletTransactionHeader::find($id)->update([
            'total_billed'  => $total_price,
            'total_discount' => $total_discount,
            'total_tax'     => $tax,
            'total_service' => $service,
            'grand_total'   => $grand_total + $tax + $service,
            'booking_id'    => $request->input('booking_id'),
            'guest_id'      => ($request->input('guest_id')) ? $request->input('guest_id') : 0,
            'date'          => $request->input('date'),
            'status'        => $type,
            'updated_by'    => Auth::id(),
            'waiters'       => $request->input('waiters'),
            'guest_num'     => ($request->input('guest_num')) ? $request->input('guest_num') : 2,
            'table_id'      => isset($getTable->id) ? $getTable->id : 0,
            'room_id'       => $request->input('room_id'),
            'bill_type'     => $request->input('bill_type'),
            'delivery_type' => $request->input('delivery_type')
        ]);

        $getDetail = OutletTransactionDetail::where('transaction_id',$id)->get();

        // RETURN QTY
        foreach ($getDetail as $key_old => $val_old) {
            $item = PosItem::find($val_old->extracharge_id);
            $qty_old = $item->stock;
            $item->stock = $qty_old + $val_old->qty;
            $item->save();
        }

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

            $item = PosItem::find($key);
            $qty_old = $item->stock;
            $item->stock = $qty_old - $qty[$key];
            $item->save();
        }

        if($type == 3){ // IF PAID
            $paid = str_replace(',', '', $request->input('pay_paid'));
            if($request->input('payment_method') != 1 && $request->input('payment_method') != 2){
                $paid = $request->input('grand_total');
            }
            OutletTransactionPayment::create([
                'transaction_id'     => $id,
                'payment_method'     => $request->input('payment_method'),
                'total_payment'     => $request->input('grand_total'),
                'total_paid'        => $paid,
                'total_change'        => $paid - (int) $request->input('grand_total'),
                'settlement_id'     => $request->input('settlement'),
                'cc_type_id'     => $request->input('cc_type'),
                'card_type'     => $request->input('card_type'),
                'card_number'     => $request->input('card_number'),
                'card_expiry_month'     => $request->input('month'),
                'card_expiry_year'     => $request->input('year'),
                'cc_holder'     => $request->input('card_holder'),
                'bank'             => $request->input('bank'),
                'created_by'        => Auth::id(),
                'bank_transfer_recipient' => $request->input('cash_account_id'),
                'guest_id'          => ($request->input('guest_id')) ? $request->input('guest_id') : 0
            ]);
        }

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return ($type == 2) ? redirect(route($this->module.".edit", ['id' => $id]))->with('displayMessage', $message) : redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param $status
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status, Request $request)
    {
        $back = $request->input('back');
        $data = OutletTransactionHeader::find($id);

        if ($status == 2) {
            $act = 'void payment';
            OutletTransactionPayment::where('transaction_id', $id)->delete();
        } elseif ($status == 1){
            $act = 'void billed';
        } else {
            $act = 'delete transaction';
        }
        $data->status = $status;

        $data->save();

        OutletTransactionDetail::where('transaction_id', $id)->update([
            'status' => $status
        ]);

        $url = ($back) ? route($this->module.'.edit', ['id' => $id]) : route($this->module.'.index');

        $message = GlobalHelper::setDisplayMessage('success', "Success to $act");
        return redirect($url)->with('displayMessage', $message);
    }

    /**
     * @param $transactionId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printReceipt($transactionId){
        $header = OutletTransactionHeader::find($transactionId);
        $detail = OutletTransactionDetail::where('transaction_id', $transactionId)->get();
        $data = [
            'header'    => $header,
            'detail'    => $detail,
            'hotel_name'   => session('name'),
            'hotel_phone'   => session('phone'),
            'hotel_fax'   => session('fax'),
            'hotel_email'   => session('email'),
            'hotel_address'   => session('address'),

        ];
        return view("print.pos-bill", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activeOrder(Request $request){
        $data['parent_menu'] = $this->parent;
        $data['dine'] = OutletTransactionHeader::where('delivery_type', 1)->where('status', 1)->where('source', 2)->get();
        $data['room'] = OutletTransactionHeader::where('delivery_type', 2)->where('status', 1)->where('source', 2)->get();
        return view($this->module.".active", $data);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDelivery($id, $status)
    {
        $data = OutletTransactionDetail::find($id);

        $data->delivery_status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', "Success to change delivery status");
        return redirect(route($this->module.".active"))->with('displayMessage', $message);
    }
}
