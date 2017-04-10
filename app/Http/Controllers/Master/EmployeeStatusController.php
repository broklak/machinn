<?php

namespace App\Http\Controllers\Master;

use App\EmployeeStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class EmployeeStatusController extends Controller
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

        $this->model = new EmployeeStatus();

        $this->module = 'employee-status';

        $this->parent = 'employees';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['parent_menu'] = $this->parent;
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
            'employee_status_name'  => 'required|max:75|min:3'
        ]);

        $this->model->create([
            'employee_status_name'   => $request->input('employee_status_name')
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
            'employee_status_name'  => 'required|max:75|min:3'
        ]);

        $data = $this->model->find($id);

        $data->employee_status_name = $request->input('employee_status_name');

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

        $data->employee_status_active = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->employee_status_active);
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
