@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Create {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <a href="{{route($route_name.'.index')}}" class="btn btn-success">View Transaction</a>
        <div id="error_messages" style="margin-top: 20px">

        </div>
        <form id="form-pos" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
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
                                        <input id="bill_number" readonly type="text" name="bill_number" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Date</label>
                                    <div class="controls">
                                        <input id="date" value="{{date('Y-m-d')}}" type="text" name="date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Customer</label>
                                    <div class="controls">
                                        <input type="radio" checked value="0" name="is_guest" id="no"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no">Not Guest</label>
                                        <input type="radio" value="1" name="is_guest" id="yes"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes">Guest</label>
                                    </div>
                                </div>
                                <div id="guest-cont" class="control-group hide">
                                    <label class="control-label">Guest</label>
                                    <div class="controls">
                                        <input type="text" id="guest_name" name="guest_name">
                                        <input type="hidden" id="guest_id" name="guest_id">
                                        <a href="#modalFindGuest" data-toggle="modal" class="btn btn-inverse">Find Guest</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dp-container" class="widget-box hide">
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
                                                <option @if(old('payment_method') == $val) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Total Bill</label>
                                    <div class="controls">
                                        <input id="pay_bill" type="number" name="pay_bill" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Total Paid</label>
                                    <div class="controls">
                                        <input id="pay_paid" type="number" name="pay_bill" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Change</label>
                                    <div class="controls">
                                        <input id="pay_change" type="number" name="pay_change" />
                                    </div>
                                </div>
                                <div id="cc-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">Settlement</label>
                                        <div class="controls">
                                            <select name="settlement">
                                                <option value="0" selected>Choose Settlement</option>
                                                @foreach($settlement as $key => $val)
                                                    <option @if(old('settlement') == $val['settlement_id']) selected="selected" @endif value="{{$val['settlement_id']}}">{{$val['settlement_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Type</label>
                                        <div class="controls">
                                            <input type="radio" value="1" name="card_type" id="cre"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="cre">Credit Card</label>
                                            <input type="radio" value="2" name="card_type" id="deb"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="deb">Debit Card</label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Number</label>
                                        <div class="controls">
                                            <input value="{{old('card_number')}}" id="card_number" type="text" name="card_number" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Holder Name</label>
                                        <div class="controls">
                                            <input value="{{old('card_holder')}}" id="card_holder" type="text" name="card_holder" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Expired Date</label>
                                        <div class="controls">
                                            <input value="{{old('card_expired_date')}}" id="card_expired_date" type="text" data-date-format="yyyy-mm-dd" name="card_expired_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Credit Card Type</label>
                                        <div class="controls">
                                            <select name="cc_type">
                                                <option value="0" selected>Choose CC Type</option>
                                                @foreach($cc_type as $key => $val)
                                                    <option @if(old('cc_type') == $val['cc_type_id']) selected="selected" @endif value="{{$val['cc_type_id']}}">{{$val['cc_type_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Bank</label>
                                        <div class="controls">
                                            <select name="bank">
                                                <option value="0" selected>Choose Bank</option>
                                                @foreach($bank as $key => $val)
                                                    <option @if(old('bank') == $val['bank_id']) selected="selected" @endif value="{{$val['bank_id']}}">{{$val['bank_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="bt-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">Account Recipient</label>
                                        <div class="controls">
                                            <select name="cash_account_id">
                                                <option value="0" selected>Choose Recipient</option>
                                                @foreach($cash_account as $key => $val)
                                                    <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                    <tr>
                                        <td colspan="5" style="text-align: right;font-weight: bold;font-size: 18px">GRAND TOTAL : <span id="grand_total_text">IDR 0</span>
                                            <input type="hidden" name="grand_total" value="0" id="grand_total">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE AS DRAFT">
                </div>
                <div class="span6">
                    <a id="billedButton" class="btn btn-success" style="display: block;width: 100%">SAVE AS BILLED</a>
                </div>
            </div>
        </form>
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