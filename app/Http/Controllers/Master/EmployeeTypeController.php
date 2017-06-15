<?php

namespace App\Http\Controllers\Master;

use App\EmployeeType;
use App\Submodules;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class EmployeeTypeController extends Controller
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
    private $submodules;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new EmployeeType();

        $this->module = 'employee-type';

        $this->parent = 'employees';

        $this->submodules = Submodules::all();
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['submodules'] = $this->submodules;
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'employee_type_name'  => 'required|max:75|min:3'
        ]);

        $created = $this->model->create([
            'employee_type_name'   => $request->input('employee_type_name')
        ]);

        $insert = [
            'create'    => $request->input('create'),
            'read'    => $request->input('read'),
            'update'    => $request->input('update'),
            'delete'    => $request->input('delete'),
        ];

        $this->insertRole($insert, $created->employee_type_id);

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successCreateData'));
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['submodules'] = $this->submodules;
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'employee_type_name'  => 'required|max:75|min:3'
        ]);

        $data = $this->model->find($id);

        $data->employee_type_name = $request->input('employee_type_name');

        $data->save();

        $insert = [
            'create'    => $request->input('create'),
            'read'    => $request->input('read'),
            'update'    => $request->input('update'),
            'delete'    => $request->input('delete'),
        ];

        $this->insertRole($insert, $id);

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successUpdateData'));
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
        if(!UserRole::checkAccess($subModule = 18, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->employee_type_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 18, $type = 'delete')){
            return view("auth.unauthorized");
        }
        UserRole::where('employee_type_id', $id)->delete();
        UserRole::clearRoleCache($id);
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $insert
     * @param $roleId
     */
    private function insertRole ($insert, $roleId) {
        // DELETE FIRST IF EXIST
        UserRole::where('employee_type_id', $roleId)->delete();
        UserRole::clearRoleCache($roleId);

        $create = ($insert['create']) ? $insert['create'] : [];
        $read = ($insert['read']) ? $insert['read'] : [];
        $update = ($insert['update']) ? $insert['update'] : [];
        $delete = ($insert['delete']) ? $insert['delete'] : [];

        foreach($create as $key => $value){
            UserRole::create([
                'employee_type_id'  => $roleId,
                'submodule_id'      => $value,
                'type'              => 'create'
            ]);
            UserRole::insertToCache($roleId, $value, 'create');
        }

        foreach($read as $key => $value){
            UserRole::create([
                'employee_type_id'  => $roleId,
                'submodule_id'      => $value,
                'type'              => 'read'
            ]);

            UserRole::insertToCache($roleId, $value, 'read');
        }

        foreach($update as $key => $value){
            UserRole::create([
                'employee_type_id'  => $roleId,
                'submodule_id'      => $value,
                'type'              => 'update'
            ]);

            UserRole::insertToCache($roleId, $value, 'update');
        }

        foreach($delete as $key => $value){
            UserRole::create([
                'employee_type_id'  => $roleId,
                'submodule_id'      => $value,
                'type'              => 'delete'
            ]);

            UserRole::insertToCache($roleId, $value, 'delete');
        }
    }
}
