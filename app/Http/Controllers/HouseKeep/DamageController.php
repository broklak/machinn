<?php

namespace App\Http\Controllers\HouseKeep;

use App\Damage;
use App\RoomNumber;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;
use App\User;

class DamageController extends Controller
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

    /**
     * @var
     */
    private $employee;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Damage();

        $this->module = 'damage';

        $this->employee = User::paginate(10);

        $this->parent = 'asset';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 11, $type = 'read')){
            return view("auth.unauthorized");
        }
        $lost = $request->input('lost');
        $type = 2;
        if($lost == '1'){
            $this->module = 'lostasset';
            $data['lost'] = $lost;
            $type = 1;
        }
        $asset_name = $request->input('asset_name');
        $rows = $this->model->where('asset_name', 'LIKE', "%$asset_name%")->where('type', $type)->paginate();
        $data['rows'] = $rows;
        $data['asset_name'] = $asset_name;
        $data['parent_menu'] = $this->parent;
        return view("house.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 11, $type = 'create')){
            return view("auth.unauthorized");
        }
        $lost = $request->input('lost');
        if($lost == '1'){
            $this->module = 'lostasset';
            $data['lost'] = $lost;
        }
        $data['room'] = RoomNumber::all();
        $data['parent_menu'] = $this->parent;
        $data['EmployeeModel'] = new User();
        $data['employee'] = $this->employee;
        return view("house.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 11, $type = 'create')){
            return view("auth.unauthorized");
        }
        $get = '';
        $this->validate($request,[
            'date'  => 'required',
            'asset_name' => 'required'
        ]);

        $this->model->create([
            'date'   => $request->input('date'),
            'asset_name'   => $request->input('asset_name'),
            'founder_employee_id'   => $request->input('founder_employee_id'),
            'description'   => $request->input('description'),
            'room_number_id'   => $request->input('room_number_id'),
            'created_by'   => Auth::id(),
            'type'      => ($request->input('lost')) ? 1 : 2
        ]);
        if($request->input('lost')){
            $get = '?lost=1';
        }

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successCreateData'));
        return redirect(route($this->module.".index").$get)->with('displayMessage', $message);
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
        if(!UserRole::checkAccess($subModule = 11, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['room'] = RoomNumber::all();
        $data['parent_menu'] = $this->parent;
        $data['EmployeeModel'] = new User();
        $data['employee'] = $this->employee;
        $data['row'] = $this->model->find($id);
        return view("house.".$this->module.".edit", $data);
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
        if(!UserRole::checkAccess($subModule = 11, $type = 'update')){
            return view("auth.unauthorized");
        }
        $get = '';
        $this->validate($request,[
            'date'  => 'required',
            'asset_name' => 'required'
        ]);
        $data = $this->model->find($id);
        if($data->type == 1){
            $get = '?lost=1';
        }
        $this->model->find($id)->update([
            'date'   => $request->input('date'),
            'asset_name'   => $request->input('asset_name'),
            'founder_employee_id'   => $request->input('founder_employee_id'),
            'description'   => $request->input('description'),
            'room_number_id'   => $request->input('room_number_id'),
            'updated_by'   => Auth::id()
        ]);

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successUpdateData'));
        return redirect(route($this->module.".index").$get)->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        if(!UserRole::checkAccess($subModule = 11, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        $data->status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 11, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $get = '';
        $data = $this->model->find($id);
        if($data->type == 1){
            $get = '?lost=1';
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index").$get)->with('displayMessage', $message);
    }
}
