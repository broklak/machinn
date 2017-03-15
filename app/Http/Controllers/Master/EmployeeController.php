<?php

namespace App\Http\Controllers\Master;

use App\Department;
use App\EmployeeStatus;
use App\EmployeeType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class EmployeeController extends Controller
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
    private $department;

    /**
     * @var
     */
    private $status;

    /**
     * @var
     */
    private $religion;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new User();

        $this->module = 'employee';

        $this->department = Department::where('department_status', 1)->get();

        $this->type = EmployeeType::where('employee_type_status', 1)->get();

        $this->status = EmployeeStatus::where('employee_status_active', 1)->get();

        $this->religion = ['islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Budha', 'Konghucu'];
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
        $data['religion'] = $this->religion;
        $data['type'] = $this->type;
        $data['department'] = $this->department;
        $data['status'] = $this->status;
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
            'username' => 'required|max:50|unique:users',
            'password' => 'required|min:4'
        ]);

        $this->model->create([
            'username'   => $request->input('username'),
            'name'   => $request->input('username'),
            'password'   => bcrypt($request->input('name')),
            'email'     => $request->input('email'),
            'nik'     => $request->input('nik'),
            'ktp'     => $request->input('ktp'),
            'birthplace'     => $request->input('birthplace'),
            'birthdate'     => $request->input('birthdate'),
            'religion'     => $request->input('religion'),
            'gender'     => $request->input('gender'),
            'address'     => $request->input('address'),
            'phone'     => $request->input('phone'),
            'department_id'     => $request->input('department_id'),
            'employee_type_id'     => $request->input('employee_type_id'),
            'employee_status_id'     => $request->input('employee_status_id'),
            'join_date'     => $request->input('join_date'),
            'npwp'     => $request->input('npwp'),
            'bank_name'     => $request->input('bank_name'),
            'bank_number'     => $request->input('bank_number'),
            'bank_account_name'     => $request->input('bank_account_name')
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
        $data['religion'] = $this->religion;
        $data['type'] = $this->type;
        $data['department'] = $this->department;
        $data['status'] = $this->status;
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
            'username' => 'required|max:50',
        ]);

        $data = $this->model->find($id);

        $data->username   = $request->input('username');
        $data->name   = $request->input('username');
        $data->password   = bcrypt($request->input('name'));
        $data->email     = $request->input('email');
        $data->nik     = $request->input('nik');
        $data->ktp     = $request->input('ktp');
        $data->birthplace     = $request->input('birthplace');
        $data->birthdate     = $request->input('birthdate');
        $data->religion     = $request->input('religion');
        $data->gender     = $request->input('gender');
        $data->address     = $request->input('address');
        $data->department_id     = $request->input('department_id');
        $data->employee_type_id  = $request->input('employee_type_id');
        $data->employee_status_id     = $request->input('employee_status_id');
        $data->join_date     = $request->input('join_date');
        $data->npwp     = $request->input('npwp');
        $data->phone     = $request->input('phone');
        $data->bank_name     = $request->input('bank_name');
        $data->bank_number     = $request->input('bank_number');
        $data->bank_account_name     = $request->input('bank_account_name');

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

        $data->employee_type_status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->employee_type_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
