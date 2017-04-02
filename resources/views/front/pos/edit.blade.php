@extends('layout.main')

@section('title', 'Home')

@section('content')

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
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Edit {{$master_module}} Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-pos" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->transaction_id])}}" method="post">
                            <input type="hidden" name="type" value="1" id="saveType">
                            {{csrf_field()}}
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="widget-box">
                                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                                            <h5>Create New Transaction</h5>
                                        </div>
                                        <div class="widget-content nopadding">
                                            <div id="form-wizard-1" class="step">
                                                <div class="control-group">
                                                    <label class="control-label">Bill Number</label>
                                                    <div class="controls">
                                                        <input id="bill_number" value="{{$row->bill_number}}" readonly type="text" name="bill_number" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Date</label>
                                                    <div class="controls">
                                                        <input id="date" value="{{$row->date}}" type="text" name="date" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Customer</label>
                                                    <div class="controls">
                                                        <input type="radio" @if($row->guest_id == 0) checked @endif value="0" name="is_guest" id="no"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no">Not Guest</label>
                                                        <input type="radio" @if($row->guest_id != 0) checked @endif value="1" name="is_guest" id="yes"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes">Guest</label>
                                                    </div>
                                                </div>
                                                <div id="guest-cont" class="control-group @if($row->guest_id == 0) hide @endif">
                                                    <label class="control-label">Guest</label>
                                                    <div class="controls">
                                                        <input type="text" id="guest_name" value="{{\App\Guest::getFullName($row->guest_id)}}" name="guest_name">
                                                        <input type="hidden" id="guest_id" value="{{$row->guest_id}}" name="guest_id">
                                                        <a href="#modalFindGuest" data-toggle="modal" class="btn btn-inverse">Find Guest</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dp-container" class="widget-box @if($row->status == 1) hide @endif ">
                                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                                            <h5>Pay Bill</h5>
                                        </div>
                                        <div class="widget-content nopadding">
                                            <div id="form-wizard-1" class="step">
                                                <input type="hidden" id="need_dp" />
                                                <div class="control-group">
                                                    <label class="control-label">Payment Method</label>
                                                    <div class="controls">
                                                        <select id="payment_method" name="payment_method">
                                                            <option value="0" disabled selected>Choose Payment Method</option>
                                                            @foreach($payment_method as $key => $val)
                                                                <option @if(isset($payment->payment_method) && $payment->payment_method == $val) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Total Bill</label>
                                                    <div class="controls">
                                                        <input readonly id="pay_bill" value="{{\App\Helpers\GlobalHelper::moneyFormat($row->grand_total)}}" type="text" name="pay_bill" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Total Paid</label>
                                                    <div class="controls">
                                                        <input value="{{(isset($payment->total_paid)) ? $payment->total_paid : 0}}" id="pay_paid" type="number" name="pay_paid" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Change</label>
                                                    <div class="controls">
                                                        <input id="pay_change" value="{{(isset($payment->total_change)) ? $payment->total_change : 0}}" type="number" name="pay_change" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="widget-box">
                                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                                            <h5>Item List</h5>
                                            <a href="#modalFindItem" data-toggle="modal" id="add_item" style="float: right;padding: 7px 10px" class="btn btn-info">Add New Item</a>
                                        </div>
                                        <div class="widget-content nopadding">
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
                                                        <td>{{\App\Extracharge::getName($val_detail->extracharge_id)}}</td>
                                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val_detail->price)}}</td>
                                                        <td>
                                                            <input type="number" name="qty[{{$val_detail->extracharge_id}}]" onchange="changeQty($(this))" onkeyup="changeQty($(this))"
                                                                   id="qty-{{$val_detail->extracharge_id}}" data-id="{{$val_detail->extracharge_id}}" class="qtyItem" value="{{$val_detail->qty}}" style="width: 30px" />
                                                            <input type="hidden" name="price[{{$val_detail->extracharge_id}}]" id="price-{{$val_detail->extracharge_id}}" value="{{$val_detail->price}}" />
                                                        </td>
                                                        <td>
                                                            <input type="number" name="discount[{{$val_detail->extracharge_id}}]" onchange="changeDiscount($(this))"
                                                                   onkeyup="changeDiscount($(this))" data-id="{{$val_detail->extracharge_id}}" value="{{$val_detail->discount}}"
                                                                   style="width: 80px" />
                                                            <input type="hidden" id="discount-{{$val_detail->extracharge_id}}" value="{{$val_detail->discount}}" />
                                                            <input type="hidden" name="subtotal[{{$val_detail->extracharge_id}}]" id="subtotal-{{$val_detail->extracharge_id}}" value="{{$val_detail->subtotal}}" />
                                                        </td>
                                                        <td>
                                                            <span id="total-{{$val_detail->extracharge_id}}">{{\App\Helpers\GlobalHelper::moneyFormat($val_detail->subtotal)}} &nbsp;</span>
                                                            <a id="deleteCart-{{$val_detail->extracharge_id}}" onclick="deleteCart($(this))" data-id="{{$val_detail->extracharge_id}}" data-price="{{$val_detail->subtotal}}">
                                                                <i class="icon-2x icon-remove"></i>
                                                            </a>
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
                                @else
                                    <div class="span12">
                                        <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SET AS PAID">
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

    {{--MODAL--}}

    <div id="modalFindGuest" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Find Guest</h3>
        </div>
        <div class="modal-body">
            <form id="searchGuestForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">Filter Guest By Name or ID</label>
                        <div class="controls">
                            <input id="searchguest" name="query" type="text" />
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="listGuest">
                @foreach($guest as $key => $val)
                    <tr class="{{($val['guest_id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                        <td>{{$val['first_name'].' '.$val['last_name']}}</td>
                        <td>{{$val['id_number']}} ({{\App\Guest::getIdType($val['id_type'])}})</td>
                        <td><a data-dismiss="modal" data-firstname="{{$val['first_name']}}" data-lastname="{{$val['last_name']}}" data-guesttype="{{$val['type']}}"
                               data-idtype="{{$val['id_type']}}" data-idnumber="{{$val['id_number']}}" data-id="{{$val['guest_id']}}" data-email="{{$val['email']}}" data-birthdate="{{$val['birthdate']}}"
                               data-religion="{{$val['religion']}}" data-gender="{{$val['gender']}}" data-job="{{$val['job']}}" data-birthplace="{{$val['birthplace']}}"
                               data-address="{{$val['address']}}" data-countryid="{{$val['country_id']}}" data-provinceid="{{$val['province_id']}}"
                               data-zipcode="{{$val['zipcode']}}" data-homephone="{{$val['homephone']}}" data-handphone="{{$val['handphone']}}" data-guesttitle="{{$val['title']}}"
                               id="guest-{{$val['guest_id']}}" class="btn btn-success chooseGuest">Choose</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalFindItem" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Find Item</h3>
        </div>
        <div class="modal-body">
            <form id="searchItemForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-item" class="step">
                    <div class="control-group">
                        <label class="control-label">Search Item</label>
                        <div class="controls">
                            <input id="searchitem" name="query" type="text" />
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="listItem">
                @foreach($item as $key => $val)
                    <tr class="{{($val['guest_id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                        <td>{{$val->extracharge_name}}</td>
                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->extracharge_price)}}</td>
                        <td>
                            <a data-dismiss="modal" data-id="{{$val->extracharge_id}}" data-price="{{$val->extracharge_price}}" data-name="{{$val->extracharge_name}}" class="btn btn-success chooseItem">Choose</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection