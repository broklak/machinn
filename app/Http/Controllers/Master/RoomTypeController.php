<?php

namespace App\Http\Controllers\Master;

use App\RoomAttribute;
use App\RoomType;
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

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new RoomType();

        $this->module = 'room-type';

        $this->attribute = RoomAttribute::where('room_attribute_status', 1)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['status'] = config('app.roomStatus');
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
        $this->validate($request,[
            'room_type_name'  => 'required|max:75|min:3',
            'room_type_max_adult'  => 'required|numeric',
            'room_type_max_child'  => 'required|numeric',
            'room_type_attributes' => 'required'
        ]);

        $this->model->create([
            'room_type_name'   => $request->input('room_type_name'),
            'room_type_max_adult'   => $request->input('room_type_max_adult'),
            'room_type_max_child'   => $request->input('room_type_max_child'),
            'room_type_banquet' => $request->input('room_type_banquet'),
            'room_type_attributes' => implode(',',$request->input('room_type_attributes'))
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
        $this->validate($request,[
            'room_type_name'  => 'required|max:75|min:3',
            'room_type_max_adult'  => 'required|numeric',
            'room_type_max_child'  => 'required|numeric',
            'room_type_attributes' => 'required'
        ]);

        $data = $this->model->find($id);

        $data->room_type_name = $request->input('room_type_name');
        $data->room_type_max_adult = $request->input('room_type_max_adult');
        $data->room_type_max_child = $request->input('room_type_max_child');
        $data->room_type_banquet = $request->input('room_type_banquet');
        $data->room_type_attributes = implode(',',$request->input('room_type_attributes'));

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

        $data->room_type_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->room_type_name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
