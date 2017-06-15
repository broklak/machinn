<?php

namespace App\Http\Controllers\HouseKeep;

use App\Lost;
use App\Guest;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class LostController extends Controller
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
    private $guest;


    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Lost();

        $this->module = 'lost';

        $this->guest = Guest::paginate(10);

        $this->parent = 'lostfound';
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
        $report_name = $request->input('report_name');
        $item_name = $request->input('item_name');
        $rows = $this->model->where('report_name', 'LIKE', "%$report_name%")->where('item_name', 'LIKE', "%$item_name%")->paginate();
        $data['rows'] = $rows;
        $data['reporter_name'] = $report_name;
        $data['item_name'] = $item_name;
        $data['parent_menu'] = $this->parent;
        return view("house.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 11, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['guestModel'] = new Guest();
        $data['guest'] = $this->guest;
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
        $this->validate($request,[
            'date'  => 'required',
            'report_name' => 'required'
        ]);

        $this->model->create([
            'date'   => $request->input('date'),
            'item_name'   => $request->input('item_name'),
            'item_color'   => $request->input('item_color'),
            'item_value'   => $request->input('item_value'),
            'place'   => $request->input('place'),
            'guest_id'   => $request->input('guest_id'),
            'report_name'   => $request->input('report_name'),
            'report_address'   => $request->input('report_address'),
            'description'   => $request->input('description'),
            'phone'   => $request->input('phone'),
            'email'   => $request->input('email'),
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
        if(!UserRole::checkAccess($subModule = 11, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['guestModel'] = new Guest();
        $data['guest'] = $this->guest;
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
        $this->validate($request,[
            'date'  => 'required',
            'report_name' => 'required'
        ]);

        $this->model->find($id)->update([
            'date'   => $request->input('date'),
            'item_name'   => $request->input('item_name'),
            'item_color'   => $request->input('item_color'),
            'item_value'   => $request->input('item_value'),
            'place'   => $request->input('place'),
            'guest_id'   => $request->input('guest_id'),
            'report_name'   => $request->input('report_name'),
            'report_address'   => $request->input('report_address'),
            'description'   => $request->input('description'),
            'phone'   => $request->input('phone'),
            'email'   => $request->input('email'),
            'updated_by'   => Auth::id(),
        ]);

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successUpdateData'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
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
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
