<?php

namespace App\Http\Controllers\Master;

use App\BanquetEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class BanquetEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = BanquetEvent::paginate(config('app.limitPerPage'));
        $data['rows'] = $rows;
        return view('master.banquet-event.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.banquet-event.create');
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
            'event_name'  => 'required|max:75|min:3'
        ]);

        BanquetEvent::create([
            'event_name'   => $request->input('event_name')
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
        return redirect(route('banquet-event.index'))->with('displayMessage', $message);
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
        $data['row'] = BanquetEvent::find($id);
        return view('master.banquet-event.edit', $data);
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
            'event_name'  => 'required|max:75|min:3'
        ]);

        $event = BanquetEvent::find($id);

        $event->event_name = $request->input('event_name');

        $event->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route('banquet-event.index'))->with('displayMessage', $message);
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
        $event = BanquetEvent::find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $event->event_status = $active;

        $event->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$event->event_name);
        return redirect(route('banquet-event.index'))->with('displayMessage', $message);
    }
}
