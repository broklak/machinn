<?php

namespace App\Http\Controllers\Master;

use App\Cost;
use Illuminate\Http\Request;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;

class CostController extends Controller
{
    /**
     * @var
     */
    private $model;

    /**
     * @var
     */
    private $module;

    private $type;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Cost();

        $this->module = 'cost';

        $this->type = ['1' => 'Fix Cost', '2' => 'Variable Cost'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'cost_name'  => 'required|max:75|min:3',
            'cost_date'  => 'required'
        ]);

        $this->model->create([
            'cost_name'   => $request->input('cost_name'),
            'cost_date'   => $request->input('cost_date'),
            'cost_type'   => $request->input('cost_type'),
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
            'cost_name'  => 'required|max:75|min:3',
            'cost_date'  => 'required'
        ]);

        $data = $this->model->find($id);

        $data->cost_name = $request->input('cost_name');
        $data->cost_type = $request->input('cost_type');
        $data->cost_date = $request->input('cost_date');

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

        $data->cost_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->cost_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
