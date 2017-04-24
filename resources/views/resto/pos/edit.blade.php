@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = 'resto.pos'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Edit {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a href="{{route($route_name.'.index')}}" class="btn btn-success">View Transaction</a>
        <div id="error_messages" style="margin-top: 20px">

        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <form id="form-pos" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->transaction_id])}}" method="post">
                            <input type="hidden" name="type" value="1" id="saveType">
                            {{csrf_field()}}
                            <div class="row-fluid">
                                <div class="span6">
                                    @include('resto.pos.header-edit')
                                    @include('resto.pos.payment-edit')
                                </div>
                                <div class="span6">
                                    <div class="widget-box">
                                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                                            <h5>Item List</h5>
                                        </div>
                                        <div class="widget-content nopadding">
                                            <div id="form-wizard-1" class="step">
                                                <div class="control-group">
                                                    <label class="control-label">Search Menu</label>
                                                    <div class="controls">
                                                        <input @if($row->status != 1) readonly @endif id="menu" type="text" name="menu" list="menu-list" />
                                                        <datalist id="menu-list">
                                                            @foreach($item as $key => $val)
                                                                <option data-id="{{$val->id}}" data-price="{{$val->cost_sales}}" value="{{$val->name}}"></option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ITEM NAME</th>
                                                    <th>PRICE</th>
                                                    <th>QTY</th>
                                                    <th>DISCOUNT</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody id="list-data">
                                                @foreach($detail as $key_detail => $val_detail)
                                                    <tr id="item-{{$val_detail->extracharge_id}}">
                                                        <td>{{\App\PosItem::getName($val_detail->extracharge_id)}}</td>
                                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val_detail->price)}}</td>
                                                        <td>
                                                            <input @if($row->status != 1) readonly @endif type="number" name="qty[{{$val_detail->extracharge_id}}]" onchange="changeQty($(this))" onkeyup="changeQty($(this))"
                                                                   id="qty-{{$val_detail->extracharge_id}}" data-id="{{$val_detail->extracharge_id}}" class="qtyItem" value="{{$val_detail->qty}}" style="width: 30px" />
                                                            <input type="hidden" name="price[{{$val_detail->extracharge_id}}]" id="price-{{$val_detail->extracharge_id}}" value="{{$val_detail->price}}" />
                                                        </td>
                                                        <td>
                                                            <input @if($row->status != 1) readonly @endif type="number" name="discount[{{$val_detail->extracharge_id}}]" onchange="changeDiscount($(this))"
                                                                   onkeyup="changeDiscount($(this))" data-id="{{$val_detail->extracharge_id}}" value="{{$val_detail->discount}}"
                                                                   style="width: 80px" />
                                                            <input type="hidden" id="discount-{{$val_detail->extracharge_id}}" value="{{$val_detail->discount}}" />
                                                            <input type="hidden" name="subtotal[{{$val_detail->extracharge_id}}]" id="subtotal-{{$val_detail->extracharge_id}}" value="{{$val_detail->subtotal}}" />
                                                        </td>
                                                        <td>
                                                            <span id="total-{{$val_detail->extracharge_id}}">{{\App\Helpers\GlobalHelper::moneyFormat($val_detail->subtotal)}} &nbsp;</span>
                                                            @if($row->status == 1)
                                                            <a id="deleteCart-{{$val_detail->extracharge_id}}" onclick="deleteCart($(this))" data-id="{{$val_detail->extracharge_id}}" data-price="{{$val_detail->subtotal}}">
                                                                <i class="icon-2x icon-remove"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" style="text-align: right;font-weight: bold;font-size: 18px">GRAND TOTAL : <span id="grand_total_text">
                                                            {{\App\Helpers\GlobalHelper::moneyFormat($row->grand_total)}}</span>
                                                        <input type="hidden" name="grand_total" value="{{$row->grand_total}}" id="grand_total">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                @if($row->status == 1)
                                    <div class="span6">
                                        <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE CHANGE">
                                    </div>
                                    <div class="span6">
                                        <a id="billedButton" class="btn btn-success" style="display: block;width: 100%">SAVE AS BILLED</a>
                                    </div>
                                @elseif($row->status == 2)
                                    <div class="span6">
                                        <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SET AS PAID">
                                    </div>
                                    <div class="span6">
                                        <a class="btn btn-danger" href="{{route('resto.pos.change-status', ['id' => $row->transaction_id, 'status' => 1])}}" style="display: block;width: 100%">VOID BILLED</a>
                                    </div>
                                @else
                                    <div class="span12">
                                        <a class="btn btn-danger" href="{{route('resto.pos.change-status', ['id' => $row->transaction_id, 'status' => 2])}}" style="display: block;width: 100%">VOID PAYMENT</a>
                                    </div>
                                @endif
                            </div>
                            {{ method_field('PUT') }}
                            <input type="hidden" id="billed" value="@if($row->status == 2) 1 @else 0 @endif">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('resto.pos.modal-guest')

@endsection