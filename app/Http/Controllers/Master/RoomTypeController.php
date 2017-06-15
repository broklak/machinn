<?php

namespace App\Http\Controllers\Master;

use App\RoomAttribute;
use App\RoomRate;
use App\RoomRateDateType;
use App\RoomType;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class RoomTypeController extends Controller
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
    private $attribute;

    /**
     * @var
     */
    private $rate;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new RoomType();

        $this->module = 'room-type';

        $this->attribute = RoomAttribute::where('room_attribute_status', 1)->get();

        $this->rate = new RoomRate();

        $this->parent = 'rooms';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!UserRole::checkAccess($subModule = 1, $type = 'read')){
            return view("auth.unauthorized");
        }
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['attribute'] = $this->attribute;
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'room_type_name'  => 'required|max:75|min:3',
            'room_type_max_adult'  => 'required|numeric',
            'room_type_max_child'  => 'required|numeric',
            'room_type_attributes' => 'required',
            'day_type_1'           => 'required|numeric',
            'day_type_2'           => 'required|numeric'
        ]);

        $create = $this->model->create([
            'room_type_name'   => $request->input('room_type_name'),
            'room_type_max_adult'   => $request->input('room_type_max_adult'),
            'room_type_max_child'   => $request->input('room_type_max_child'),
            'room_type_banquet' => $request->input('room_type_banquet'),
            'room_type_attributes' => implode(',',$request->input('room_type_attributes')),
            ''
        ]);

        $this->rate->create([
            'room_rate_day_type_id' => 1,
            'room_rate_type_id'     => $create->room_type_id,
            'room_price'            => $request->input('day_type_1')
        ]);

        $this->rate->create([
            'room_rate_day_type_id' => 2,
            'room_rate_type_id'     => $create->room_type_id,
            'room_price'            => $request->input('day_type_2')
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['weekday'] = $this->rate->where('room_rate_day_type_id', 1)->where('room_rate_type_id', $id)->first();
        $data['weekend'] = $this->rate->where('room_rate_day_type_id', 2)->where('room_rate_type_id', $id)->first();
        $data['attribute'] = $this->attribute;
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'room_type_name'  => 'required|max:75|min:3',
            'room_type_max_adult'  => 'required|numeric',
            'room_type_max_child'  => 'required|numeric',
            'room_type_attributes' => 'required',
            'day_type_1'           => 'required|numeric',
            'day_type_2'           => 'required|numeric'
        ]);

        $data = $this->model->find($id);

        $data->room_type_name = $request->input('room_type_name');
        $data->room_type_max_adult = $request->input('room_type_max_adult');
        $data->room_type_max_child = $request->input('room_type_max_child');
        $data->room_type_banquet = $request->input('room_type_banquet');
        $data->room_type_attributes = implode(',',$request->input('room_type_attributes'));

        $data->save();

        $weekday = $this->rate->where('room_rate_day_type_id', 1)->where('room_rate_type_id', $id)->first();
        $weekday->room_price = $request->input('day_type_1');
        $weekday->save();

        $weekend = $this->rate->where('room_rate_day_type_id', 2)->where('room_rate_type_id', $id)->first();
        $weekend->room_price = $request->input('day_type_2');
        $weekend->save();

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
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->room_type_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 1, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
