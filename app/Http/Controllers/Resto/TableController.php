<?php

namespace App\Http\Controllers\Resto;

use App\PosTable;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class TableController extends Controller
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

        $this->model = new PosTable();

        $this->module = 'table';

        $this->parent = 'master-resto';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 12, $type = 'read')){
            return view("auth.unauthorized");
        }
        $table_name = $request->input('name');
        $table_type = $request->input('type');

        $where[] = ['name', 'LIKE', "%$table_name%"];

        if($table_type != 0){
            $where[] = ['type', '=', $table_type];
        }

        $data['parent_menu'] = $this->parent;
        $data['table_name'] = $table_name;
        $data['table_type'] = $table_type;
        $rows = $this->model->where($where)->paginate();
        $data['rows'] = $rows;
        return view("resto.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 12, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        return view("resto.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 12, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'name'  => 'required|max:75|min:3'
        ]);

        $this->model->create([
            'name'   => $request->input('name'),
            'desc'   => $request->input('desc'),
            'type'   => ($request->input('type')) ? $request->input('type') : 1,
            'created_by'   => Auth::id(),
        ]);

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
        if(!UserRole::checkAccess($subModule = 12, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['row'] = $this->model->find($id);
        return view("resto.".$this->module.".edit", $data);
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
        if(!UserRole::checkAccess($subModule = 12, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'name'  => 'required|max:75|min:3'
        ]);

        $data = $this->model->find($id)->update([
            'name'   => $request->input('name'),
            'desc'   => $request->input('desc'),
            'type'   => $request->input('type'),
            'updated_by'   => Auth::id(),
        ]);

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
        if(!UserRole::checkAccess($subModule = 12, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 12, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
