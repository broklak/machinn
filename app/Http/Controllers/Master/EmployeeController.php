<?php

namespace App\Http\Controllers\Master;

use App\Department;
use App\EmployeeStatus;
use App\EmployeeType;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * @var string
     */
    private $parent;

    /**
     * @var
     */
    private $url;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new User();

        $this->module = 'employee';

        $this->department = Department::where('department_status', 1)->get();

        $this->type = EmployeeType::where('employee_type_status', 1)->get();

        $this->status = EmployeeStatus::where('employee_status_active', 1)->get();

        $this->religion = config('app.religion');

        $this->parent = 'employees';

        $this->url = (\Illuminate\Support\Facades\Request::segment(1) == 'setting') ? 'setting.employee' : 'employee';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!UserRole::checkAccess($subModule = 18, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['header'] = (\Illuminate\Support\Facades\Request::segment(1) == 'setting') ? 'User' : 'Employee';
        $data['url'] = $this->url;
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['header'] = (\Illuminate\Support\Facades\Request::segment(1) == 'setting') ? 'User' : 'Employee';
        $data['url'] = $this->url;
        $data['parent_menu'] = $this->parent;
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'username' => 'required|max:50|unique:users',
            'password' => 'required|min:4',
            'department_id' => 'required',
            'employee_type_id' => 'required'
        ]);

        $this->model->create([
            'username'   => $request->input('username'),
            'name'   => $request->input('username'),
            'password'   => bcrypt($request->input('password')),
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
        return redirect(route($this->url.".index"))->with('displayMessage', $message);
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['header'] = (\Illuminate\Support\Facades\Request::segment(1) == 'setting') ? 'User' : 'Employee';
        $data['url'] = $this->url;
        $data['parent_menu'] = $this->parent;
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'username' => 'required|max:50',
        ]);

        $data = $this->model->find($id);

        $data->username   = $request->input('username');
        $data->name   = $request->input('username');
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

        $newpass = $request->input('password');

        if($newpass){
            $data->password = bcrypt($newpass);
        }

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route($this->url.".index"))->with('displayMessage', $message);
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        $data->employee_type_status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->employee_type_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changePassword (Request $request) {
        $submit = $request->input('submit');
        $userId = Auth::id();

        if($submit != null) {
            $this->validate($request, [
                'newpass' => 'required|min:6',
                'conpass' => 'required|same:newpass',
            ]);
            $newpass = $request->input('newpass');

            $user = User::find($userId);

            $user->password = bcrypt($newpass);

            $user->save();

            $message = GlobalHelper::setDisplayMessage('success', 'Success to change your password');
            return redirect(route('change-password'))->with('displayMessage', $message);
        }
        return view('master.'.$this->module.'.change-password');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 18, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', 'Success to delete data');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile() {
        if(!UserRole::checkAccess($subModule = 18, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['row'] = DB::table('hotel_profile')->first();
        return view('master.'.$this->module.'.company', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeProfile(Request $request){
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $name = $request->input('name');
        $phone = $request->input('phone');
        $fax = $request->input('fax');
        $email = $request->input('email');
        $address = $request->input('address');

        $data = [
            'name'      => $name,
            'phone'     => $phone,
            'fax'       => $fax,
            'email'     => $email,
            'address'   => $address,

        ];

        if ($request->file('logo')) {
            $request->logo->storeAs('img/matrix', 'logo-hotel.png');
            $data['logo'] = 'logo-hotel.png';
        }

        session($data);

        DB::table('hotel_profile')->where('id', 1)->update($data);
        $message = GlobalHelper::setDisplayMessage('success', 'Success to update hotel profile');
        return redirect(route("profile"))->with('displayMessage', $message);
    }
}
