<?php

namespace App\Http\Controllers\Resto;

use App\PosTax;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class TaxPosController extends Controller
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

        $this->model = new PosTax();

        $this->module = 'tax';

        $this->parent = 'master-resto';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!UserRole::checkAccess($subModule = 12, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $rows = $this->model->paginate();
        $data['rows'] = $rows;
        return view("resto.".$this->module.".index", $data);
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
            'name'  => 'required|max:75|min:3',
            'percentage'  => 'required',
        ]);

        $data = $this->model->find($id)->update([
            'name'   => $request->input('name'),
            'percentage'   => $request->input('percentage'),
            'updated_by'   => Auth::id(),
        ]);

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successUpdateData'));
        return redirect(route('pos.'.$this->module.".index"))->with('displayMessage', $message);
    }
}
