<?php

namespace App\Http\Controllers\Master;

use App\Partner;
use App\PartnerGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class PartnerController extends Controller
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
    private $group;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Partner();

        $this->module = 'partner';

        $this->group = PartnerGroup::where('partner_group_status', 1)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $data['group'] = $this->group;
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
            'partner_name'  => 'required|max:75|min:3',
            'partner_group_id'  => 'required',
            'discount_weekend'  => 'required',
            'discount_weekday'  => 'required',
            'discount_special'  => 'required',
        ]);

        $this->model->create([
            'partner_name'   => $request->input('partner_name'),
            'partner_group_id'   => $request->input('partner_group_id'),
            'discount_weekend'   => $request->input('discount_weekend'),
            'discount_weekday'   => $request->input('discount_weekday'),
            'discount_special'   => $request->input('discount_special')
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
        $data['group'] = $this->group;
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
            'partner_name'  => 'required|max:75|min:3',
            'discount_weekend'   => 'required',
            'discount_weekday'   => 'required',
            'discount_special'   => 'required'
        ]);

        $data = $this->model->find($id);

        $data->partner_name = $request->input('partner_name');
        $data->partner_group_id = $request->input('partner_group_id');
        $data->discount_weekday = $request->input('discount_weekday');
        $data->discount_weekend = $request->input('discount_weekend');
        $data->discount_special = $request->input('discount_special');

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

        $data->partner_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->partner_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
