<?php

namespace App\Http\Controllers\Back;

use App\CashAccount;
use App\CashTransaction;
use App\Mutation;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class MutationController extends Controller
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

        $this->model = new Mutation();

        $this->module = 'mutation';

        $this->parent = 'back-transaction';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 16, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $status = ($request->input('status')) ? $request->input('status') : 0;

        $data['parent_menu'] = $this->parent;
        $data['status'] = $status;
        $data['start'] = $start;
        $data['end'] = $end;
        $rows = $this->model->getMutation($start, $end, $status);
        $data['rows'] = $rows;
        return view("back.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 16, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['cash_account'] = CashAccount::all();
        $data['parent_menu'] = $this->parent;
        return view("back.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 16, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'date'  => 'required',
            'amount'  => 'required',
            'from'  => 'required',
            'to'  => 'required',
        ]);

        $created = $this->model->create([
            'date'      => $request->input('date'),
            'amount'      => $request->input('amount'),
            'desc'      => $request->input('description'),
            'from'      => $request->input('from'),
            'to'      => $request->input('to'),
            'created_by'      => Auth::id(),
            'status'        => 0
        ]);

        // INSERT TO CASH TRANSACTION
        $insertCashTransaction =
                [
                    'mutation_id'        => $created->id,
                    'amount'            => $request->input('amount'),
                    'desc'              => $request->input('description'),
                    'cash_account_id'   => $request->input('from'),
                    'payment_method'    => 4,
                    'type'              => 1
                ];
        CashTransaction::insert($insertCashTransaction);

        $insertCashTransaction =
            [
                'mutation_id'        => $created->id,
                'amount'            => $request->input('amount'),
                'desc'              => $request->input('description'),
                'cash_account_id'   => $request->input('to'),
                'payment_method'    => 4,
                'type'              => 2
            ];
        CashTransaction::insert($insertCashTransaction);

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
        if(!UserRole::checkAccess($subModule = 16, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['cash_account'] = CashAccount::all();
        $data['row'] = $this->model->find($id);
        return view("back.".$this->module.".edit", $data);
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
        if(!UserRole::checkAccess($subModule = 16, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'date'  => 'required',
            'amount'  => 'required',
            'from'  => 'required',
            'to'  => 'required',
        ]);

        $data = $this->model->find($id)->update([
            'date'      => $request->input('date'),
            'amount'      => $request->input('amount'),
            'desc'      => $request->input('description'),
            'from'      => $request->input('from'),
            'to'      => $request->input('to'),
            'updated_by'      => Auth::id()
        ]);

        CashTransaction::where('mutation_id', $id)->delete();
        // INSERT TO CASH TRANSACTION
        $insertCashTransaction =
            [
                'mutation_id'        => $id,
                'amount'            => $request->input('amount'),
                'desc'              => $request->input('description'),
                'cash_account_id'   => $request->input('from'),
                'payment_method'    => 4,
                'type'              => 1
            ];
        CashTransaction::insert($insertCashTransaction);

        $insertCashTransaction =
            [
                'mutation_id'        => $id,
                'amount'            => $request->input('amount'),
                'desc'              => $request->input('description'),
                'cash_account_id'   => $request->input('to'),
                'payment_method'    => 4,
                'type'              => 2
            ];
        CashTransaction::insert($insertCashTransaction);

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
        if(!UserRole::checkAccess($subModule = 16, $type = 'update')){
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
        if(!UserRole::checkAccess($subModule = 16, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        CashTransaction::where('mutation_id', $id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
