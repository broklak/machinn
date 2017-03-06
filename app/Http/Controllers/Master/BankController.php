<?php

namespace App\Http\Controllers\Master;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\GlobalHelper;

class BankController extends Controller
{
    /**
     * @var
     */
    const limit = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Bank::paginate(self::limit);
        $data['rows'] = $rows;
        return view('master.bank.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.bank.create');
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
            'bank_name'  => 'required|max:75|min:3'
        ]);

        Bank::create([
           'bank_name'   => $request->input('bank_name')
        ]);

        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
        return redirect(route('bank.index'))->with('displayMessage', $message);
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
        $data['row'] = Bank::find($id);
        return view('master.bank.edit', $data);
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
            'bank_name'  => 'required|max:75|min:3'
        ]);

        $bank = Bank::find($id);

        $bank->bank_name = $request->input('bank_name');

        $bank->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
        return redirect(route('bank.index'))->with('displayMessage', $message);
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
        $bank = Bank::find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $bank->bank_status = $active;

        $bank->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$bank->bank_name);
        return redirect(route('bank.index'))->with('displayMessage', $message);
    }
}
