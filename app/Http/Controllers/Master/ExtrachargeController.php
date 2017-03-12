<?php

namespace App\Http\Controllers\Master;

use App\Extracharge;
use App\ExtrachargeGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class ExtrachargeController extends Controller
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
    private $type;

    /**
     * @var
     */
    private $group;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Extracharge();

        $this->module = 'extracharge';

        $this->type = ['1' => 'One Time', '2' => 'Reoccuring'];

        $this->group = ExtrachargeGroup::where('extracharge_group_status', 1)->get();
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
        $data['type'] = $this->type;
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
            'extracharge_name'  => 'required|max:75|min:3'
        ]);

        $this->model->create([
            'extracharge_name'   => $request->input('extracharge_name'),
            'extracharge_type'   => $request->input('extracharge_type'),
            'extracharge_group_id'   => $request->input('extracharge_group_id'),

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
        $data['type'] = $this->type;
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
            'extracharge_name'  => 'required|max:75|min:3'
        ]);

        $data = $this->model->find($id);

        $data->extracharge_name = $request->input('extracharge_name');
        $data->extracharge_group_id = $request->input('extracharge_group_id');
        $data->extracharge_type = $request->input('extracharge_type');

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

        $data->extracharge_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->extracharge_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
