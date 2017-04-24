<?php

namespace App\Http\Controllers\Resto;

use App\PosCategory;
use App\PosItem;
use App\PosTax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;

class ItemController extends Controller
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

        $this->model = new PosItem();

        $this->module = 'item';

        $this->parent = 'master-resto';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item_name = $request->input('name');
        $item_type = $request->input('type');

        $where[] = ['name', 'LIKE', "%$item_name%"];

        if($item_type != 0){
            $where[] = ['category_id', '=', $item_type];
        }

        $data['parent_menu'] = $this->parent;
        $data['item_name'] = $item_name;
        $data['item_type'] = $item_type;
        $data['category'] = PosCategory::all();
        $rows = $this->model->where($where)->paginate();
        $data['rows'] = $rows;
        return view("resto.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tax'] = PosTax::all();
        $data['category'] = PosCategory::all();
        $data['parent_menu'] = $this->parent;
        return view("resto.".$this->module.".create", $data);
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
            'name'  => 'required|max:75|min:3',
            'category_id'  => 'required|max:75',
            'fnb'           => 'required',
            'cost_basic'    => 'required',
            'cost_sales'    => 'required'
        ]);

        $basic = str_replace(',', '', $request->input('cost_basic'));
        $sales = str_replace(',', '', $request->input('cost_sales'));
        $tax = str_replace(',', '', $request->input('cost_before_tax'));

        $this->model->create([
            'name'   => $request->input('name'),
            'category_id'   => $request->input('category_id'),
            'fnb_type'   => $request->input('fnb'),
            'cost_sales'   => $sales,
            'cost_basic'   => $basic,
            'cost_before_tax'   => $tax,
            'created_by'        => Auth::id(),
            'stock'         => 0,
            'status'        => 1
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
        $data['tax'] = PosTax::all();
        $data['category'] = PosCategory::all();
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
        $this->validate($request,[
            'name'  => 'required|max:75|min:3',
            'category_id'  => 'required|max:75',
            'fnb'           => 'required',
            'cost_basic'    => 'required',
            'cost_sales'    => 'required'
        ]);

        $basic = str_replace(',', '', $request->input('cost_basic'));
        $sales = str_replace(',', '', $request->input('cost_sales'));
        $tax = str_replace(',', '', $request->input('cost_before_tax'));

        $data = $this->model->find($id)->update([
            'name'   => $request->input('name'),
            'category_id'   => $request->input('category_id'),
            'fnb_type'   => $request->input('fnb'),
            'cost_sales'   => $sales,
            'cost_basic'   => $basic,
            'cost_before_tax'   => $tax,
            'updated_by'   => Auth::id(),
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

        $data->status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of '.$data->name);
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stock (Request $request){
        $item_name = $request->input('name');
        $item_type = $request->input('type');

        $where[] = ['name', 'LIKE', "%$item_name%"];

        if($item_type != 0){
            $where[] = ['status', '=', $item_type];
        }

        $data['parent_menu'] = $this->parent;
        $data['item_name'] = $item_name;
        $data['item_type'] = $item_type;
        $data['category'] = PosCategory::all();
        $rows = $this->model->where($where)->paginate();
        $data['rows'] = $rows;
        return view("resto.".$this->module.".stock", $data);
    }
}
