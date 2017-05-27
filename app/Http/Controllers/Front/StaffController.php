<?php

namespace App\Http\Controllers\Front;

use App\Department;
use App\EmployeeStatus;
use App\EmployeeType;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
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

        $this->religion = config('app.religion');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 2, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = 'info';
        $data['department'] = $this->department;
        $data['name'] = $request->input('name');

        $where = [];

        if($data['name'] != null){
            $where[] = ['name', 'LIKE', '%'.$data['name'].'%'];
        }

        if($request->input('department') != 0){
            $where[] = ['department_id', '=', $request->input('department')];
        }

        $data['dept'] = $request->input('department');
        $data['model'] = $this->model;
        $rows = User::where($where)->paginate(config('limitPerPage'));
        $data['rows'] = $rows;
        return view("master.staff.index", $data);
    }
}
