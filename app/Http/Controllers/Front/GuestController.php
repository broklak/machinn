<?php

namespace App\Http\Controllers\Front;

use App\BookingHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Guest;
use App\Helpers\GlobalHelper;
use App\Country;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    /**
     * @var
     */
    private $model;

    /**
     * @var
     */
    private $module;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Guest();

        $this->module = 'guest';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->model->paginate(config('app.limitPerPage'));
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
        $data['country'] = Country::where('country_status', 1)->get();
        $data['religion'] = config('app.religion');
        $data['idType'] = config('app.guestIdentificationType');
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
            'guest_title'  => 'required',
            'first_name'    => 'required|max:25',
            'last_name'    => 'required|max:25',
            'id_type'       => 'required',
            'id_number'     => 'required',
            'handphone'     => 'required',
            'gender'        => 'required',
            'religion'      => 'required',
            'birthdate'      => 'required'
        ]);

        $this->model->create([
            'first_name'   => $request->input('first_name'),
            'last_name'   => $request->input('last_name'),
            'id_type'   => $request->input('id_type'),
            'id_number'   => $request->input('id_number'),
            'title'   => $request->input('guest_title'),
            'type'   => ($request->input('guest_type')) ? $request->input('guest_type') : 1,
            'birthdate' => $request->input('birthdate'),
            'birthplace' => $request->input('birthplace'),
            'religion' => $request->input('religion'),
            'gender' => $request->input('gender'),
            'job' => $request->input('job'),
            'address' => $request->input('address'),
            'country_id' => $request->input('country_id'),
            'email' => $request->input('email'),
            'homephone' => $request->input('homephone'),
            'handphone' => $request->input('handphone'),
            'created_by' => Auth::id()
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
        $data['country'] = Country::where('country_status', 1)->get();
        $data['religion'] = config('app.religion');
        $data['idType'] = config('app.guestIdentificationType');
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
            'guest_title'  => 'required',
            'first_name'    => 'required|max:25',
            'last_name'    => 'required|max:25',
            'id_type'       => 'required',
            'id_number'     => 'required',
            'handphone'     => 'required',
            'gender'        => 'required',
            'religion'      => 'required',
            'birthdate'      => 'required'
        ]);

        $this->model->find($id)->update([
            'first_name'   => $request->input('first_name'),
            'last_name'   => $request->input('last_name'),
            'id_type'   => $request->input('id_type'),
            'id_number'   => $request->input('id_number'),
            'title'   => $request->input('guest_title'),
            'type'   => $request->input('guest_type'),
            'birthdate' => $request->input('birthdate'),
            'birthplace' => $request->input('birthplace'),
            'religion' => $request->input('religion'),
            'gender' => $request->input('gender'),
            'job' => $request->input('job'),
            'address' => $request->input('address'),
            'country_id' => $request->input('country_id'),
            'email' => $request->input('email'),
            'homephone' => $request->input('homephone'),
            'handphone' => $request->input('handphone'),
            'updated_by' => Auth::id()
        ]);

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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkinReport(Request $request){
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');

        $data['rows'] = Guest::getTotalCheckInGuest($start, $end);
        $data['start'] = $start;
        $data['end'] = $end;
        return view("master.".$this->module.".checkin-report", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statistic(Request $request){
        $type = ($request->input('type')) ? $request->input('type') : 'gender';
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');

        $data['rows'] = Guest::getStatistic($start, $end, $type);
        $data['start'] = $start;
        $data['end'] = $end;
        $data['type'] = $type;
        return view("master.".$this->module.".statistic", $data);
    }

}
