<?php

namespace App\Http\Controllers\Back;

use App\AccountReceivable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class AccountReceivableController extends Controller
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

        $this->model = new AccountReceivable();

        $this->module = 'account-receivable';

        $this->parent = 'account-receivable';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $paid = ($request->input('paid')) ? $request->input('paid') : 0;
        $rows = $this->model->getAccReceivable($start, $end, $paid);
        $data['rows'] = $rows;
        $data['paid'] = $paid;
        $data['start'] = $start;
        $data['end'] = $end;
        $data['parent_menu'] = $this->parent;
        return view("back.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $data['parent_menu'] = $this->parent;
//        return view("master.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request,[
//            'bank_name'  => 'required|max:75|min:3'
//        ]);
//
//        $this->model->create([
//            'bank_name'   => $request->input('bank_name')
//        ]);
//
//        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
//        return redirect(route($this->module.".index"))->with('displayMessage', $message);
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
//        $data['parent_menu'] = $this->parent;
//        $data['row'] = $this->model->find($id);
//        return view("master.".$this->module.".edit", $data);
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
//        $this->validate($request,[
//            'bank_name'  => 'required|max:75|min:3'
//        ]);
//
//        $data = $this->model->find($id);
//
//        $data->bank_name = $request->input('bank_name');
//
//        $data->save();
//
//        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
//        return redirect(route($this->module.".index"))->with('displayMessage', $message);
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
//        $data = $this->model->find($id);
//
//        if($status == 1){
//            $active = 0;
//        } else {
//            $active = 1;
//        }
//
//        $data->bank_status = $active;
//
//        $data->save();
//
//        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->bank_name);
//        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
//        $this->model->find($id)->delete();
//        $message = GlobalHelper::setDisplayMessage('success', 'Success to delete data');
//        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
