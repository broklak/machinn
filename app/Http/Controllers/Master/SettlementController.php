<?php

namespace App\Http\Controllers\Master;

use App\Bank;
use App\Settlement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class SettlementController extends Controller
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
    private $bank;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Settlement();

        $this->module = 'settlement';

        $this->bank = Bank::where('bank_status', 1)->get();

        $this->parent = 'payment';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['parent_menu'] = $this->parent;
        $data['model'] = $this->model;
        $rows = $this->model->paginate();
        $data['rows'] = $rows;
        return view("master.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['parent_menu'] = $this->parent;
        $data['bank'] = $this->bank;
        return view("master.".$this->module.".create", $data);
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
            'settlement_name'  => 'required|max:75|min:3',
            'settlement_bank_id'  => 'required',
        ]);

        $this->model->create([
            'settlement_name'   => $request->input('settlement_name'),
            'settlement_bank_id'   => $request->input('settlement_bank_id')
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
        $data['parent_menu'] = $this->parent;
        $data['bank'] = $this->bank;
        $data['row'] = $this->model->find($id);
        return view("master.".$this->module.".edit", $data);
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
            'settlement_name'  => 'required|max:75|min:3'
        ]);

        $data = $this->model->find($id);

        $data->settlement_name = $request->input('settlement_name');
        $data->settlement_bank_id = $request->input('settlement_bank_id');

        $data->save();

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
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->settlement_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->settlement_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', 'Success to delete data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
