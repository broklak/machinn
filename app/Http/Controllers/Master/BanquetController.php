<?php

namespace App\Http\Controllers\Master;

use App\Banquet;
use App\BanquetEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class BanquetController extends Controller
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
        $rows = Banquet::paginate(config('app.limitPerPage'));
        $data['rows'] = $rows;
        return view('master.banquet.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.banquet.create');
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
            'banquet_name'  => 'required|max:75|min:3',
            'banquet_start'  => 'required|max:75|min:3',
            'banquet_end'  => 'required|max:75|min:3',

        ]);

        Banquet::create([
            'banquet_name'   => $request->input('banquet_name'),
            'banquet_start'   => $request->input('banquet_start'),
            'banquet_end'   => $request->input('banquet_end'),

        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
        return redirect(route('banquet.index'))->with('displayMessage', $message);
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
        $data['row'] = Banquet::find($id);
        return view('master.banquet.edit', $data);
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
            'banquet_name'  => 'required|max:75|min:3',
            'banquet_start'  => 'required|max:75|min:3',
            'banquet_end'  => 'required|max:75|min:3',

        ]);

        $banquet = Banquet::find($id);

        $banquet->banquet_name = $request->input('banquet_name');
        $banquet->banquet_start = $request->input('banquet_start');
        $banquet->banquet_end = $request->input('banquet_end');

        $banquet->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route('banquet.index'))->with('displayMessage', $message);
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
        $banquet = Banquet::find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $banquet->banquet_status = $active;

        $banquet->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$banquet->banquet_name);
        return redirect(route('banquet.index'))->with('displayMessage', $message);
    }
}
