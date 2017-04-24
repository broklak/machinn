@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Item and Price List</h5>
                        <div class="filter-data">
                            <form>
                                <input type="text" name="name" value="{{$item_name}}" placeholder="Search by Item Name">
                                <select name="type">
                                    <option @if($item_type == 0) selected @endif value="0">All Stock</option>
                                    <option @if($item_type == 1) selected @endif value="1">Stock Available</option>
                                    <option @if($item_type == 2) selected @endif value="2">Out of Stock</option>
                                </select>
                                <input type="submit" class="btn btn-primary" value="Search">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td width="25%">{{$val->name}}</td>
                                        <td width="25%">{{\App\PosCategory::getName($val->category_id)}}</td>
                                        <td width="15%">{{\App\Helpers\GlobalHelper::moneyFormat($val->cost_sales)}}</td>
                                        <td><input onfocus="formatStock($(this))" style="width: 30px" type="text" name="stock" id="stock-{{$val->id}}" value="{{$val->stock}}"></td>
                                        <td><button onclick="changeStock($(this))" data-id="{{$val->id}}"
                                                    data-name="{{$val->name}}" data-stock="{{$val->stock}}" class="btm btn-primary">Update Stock</button>
                                            <button onclick="setOutOfStock($(this))" data-id="{{$val->id}}"
                                                    data-name="{{$val->name}}" data-stock="{{$val->stock}}" class="btm btn-danger">Set Out Of Stock</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection