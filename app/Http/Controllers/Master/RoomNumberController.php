<?php

namespace App\Http\Controllers\Master;

use App\BookingRoom;
use App\PropertyFloor;
use App\RoomNumber;
use App\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class RoomNumberController extends Controller
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
    private $floor;

    /**
     * @var
     */
    private $type;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new RoomNumber();

        $this->module = 'room-number';

        $this->floor = PropertyFloor::where('property_floor_status', 1)->get();

        $this->type = RoomType::where('room_type_status', 1)->get();

        $this->parent = 'rooms';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['parent_menu'] = $this->parent;
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
        $data['parent_menu'] = $this->parent;
        $data['type'] = $this->type;
        $data['floor'] = $this->floor;
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
            'room_number_code'  => 'required|max:75|min:3',
            'room_type_id'  => 'required|numeric',
            'room_floor_id'  => 'required|numeric',
        ]);

        $this->model->create([
            'room_number_code'   => $request->input('room_number_code'),
            'room_type_id'   => $request->input('room_type_id'),
            'room_floor_id'   => $request->input('room_floor_id')
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
        $data['type'] = $this->type;
        $data['floor'] = $this->floor;
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
            'room_number_code'  => 'required|max:75|min:3',
            'room_type_id'  => 'required|numeric',
            'room_floor_id'  => 'required|numeric',
        ]);

        $data = $this->model->find($id);

        $data->room_number_code = $request->input('room_number_code');
        $data->room_type_id = $request->input('room_type_id');
        $data->room_floor_id = $request->input('room_floor_id');

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

        $data->room_number_status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of room '.$data->room_number_code);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewRoom (Request $request){
        $data['parent_menu'] = 'room-transaction';
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d');
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d', strtotime("+14 days"));

        $datediff = floor(abs(strtotime($start) - strtotime($end))) / (60 * 60 * 24);

        $room = BookingRoom::getAllRoomBooked($start, $end);

        $modifiedKey = array();
        foreach($room as $key => $val){
            $modifiedKey[$val->room_number_id.':'.$val->room_transaction_date] = $val;
        }

        $data['room'] = $modifiedKey;
        $data['start'] = $start;
        $data['end'] = $end;
        $data['date_diff'] = $datediff;
        $data['room_type'] = RoomType::where('room_type_status', 1)->get();

        return view("master.".$this->module.".view", $data);
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function houseKeep(){
        $checkin = date('Y-m-d');
        $checkout = date('Y-m-d', strtotime('+1 day'));
        $getRoom = RoomNumber::getRoomAvailable($checkin, $checkout, $filter = array());
        $mod = [];

        foreach($getRoom as $key => $val){
            $mod[$val->room_type_name]['floor'][$val->property_floor_name][] = (array)$val;
        }

        $html = GlobalHelper::generateHTMLHouseKeeping($mod);
        $data['html'] = $html;
        return view('house.dashboard',$data);
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeHkStatus($id, $status) {
        $data = $this->model->find($id);

        $data->hk_status = $status;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of room '.$data->room_number_code);
        return redirect(route("house.dashboard"))->with('displayMessage', $message);
    }
}
