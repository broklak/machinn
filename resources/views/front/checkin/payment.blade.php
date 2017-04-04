@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}} Detail</h1>
    </div>
    <div class="container-fluid">
        @if($header->payment_status == 3)
            <label class="label large label-success">PAID</label>
        @else
            <label class="label large label-important">UNPAID</label>
        @endif
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box title">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Detail In House Guest</h5>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-detail">
                            <tr>
                                <td class="title">Booking Code</td>
                                <td>{{$header->booking_code}}</td>
                                <td class="title">Source</td>
                                <td>{{\App\Partner::getName($header->partner_id)}}</td>
                            </tr>
                            <tr>
                                <td class="title">Nama</td>
                                <td>{{\App\Guest::getTitleName($guest->title) . ' '. $guest->first_name . ' ' . $guest->last_name}}</td>
                                <td class="title">ID Number</td>
                                <td>{{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
                            </tr>
                            <tr>
                                <td class="title">Room List</td>
                                <td>{{\App\RoomNumber::getRoomCodeList($header->room_list)}}</td>
                                <td class="title">Guest Total</td>
                                <td>Adult : {{$header->adult_num}} , Child : {{$header->child_num}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box title">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Room Bills</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>DATE</th>
                                <th>ROOM NUMBER</th>
                                <th>ROOM RATE PRICE</th>
                                <th>ROOM PLAN PRICE</th>
                                <th>DISCOUNT</th>
                                <th>TOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($detail as $key => $value)
                                <tr>
                                    <td>{{date('j F Y', strtotime($value->room_transaction_date))}}</td>
                                    <td>{{\App\RoomNumber::getCode($value->room_number_id)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->room_rate)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->room_plan_rate)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->discount)}}</td>
                                    <td id="sub_text_{{$value->booking_room_id}}">{{\App\Helpers\GlobalHelper::moneyFormat($value->subtotal)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" style="text-align: right;font-weight: bold;font-size: 14px">TOTAL UNPAID ROOM BILLS :
                                    <span id="grand_rate_text">{{\App\Helpers\GlobalHelper::moneyFormat($header->grand_total)}}</span>
                                    <input type="hidden" id="grand_rate" name="grand_total" value="{{$header->grand_total}}">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="widget-box title">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Extracharge Bills</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>DATE</th>
                                <th>ROOM</th>
                                <th>EXTRACHARGE</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>DISCOUNT</th>
                                <th>TOTAL</th>
                            </tr>
                            </thead>
                            <tbody id="list-data">
                            @foreach($extra as $key => $value)
                                <tr>
                                    <td>{{date('j F Y', strtotime($value->created_at))}}</td>
                                    <td>{{$value->booking_room_id}}</td>
                                    <td>{{\App\Extracharge::getName($value->extracharge_id)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->price)}}</td>
                                    <td>{{$value->qty}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->discount)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->total_payment)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="8" style="text-align: right;font-weight: bold;font-size: 14px">TOTAL UNPAID EXTRACHARGE BILLS : <span id="grand_total_text">
                                        {{\App\Helpers\GlobalHelper::moneyFormat($total_unpaid_extra)}}</span>
                                    <input type="hidden" name="grand_total" value="{{$total_unpaid_extra}}" id="grand_total">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($payment) > 0)
                    <div class="widget-box title">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Paid Bills</h5>
                        </div>
                        <div class="widget-content tab-content">
                            <table class="table table-bordered table-invoice-full">
                                <thead>
                                <tr>
                                    <th class="head0">Date</th>
                                    <th class="head1">Description</th>
                                    <th class="head0">Payment Method</th>
                                    <th class="head0 right">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment as $key => $val)
                                    <tr>
                                        <td>{{date('j F Y', strtotime($val['created_at']))}}</td>
                                        <td>{{\App\BookingPayment::setDescription($val->type, $val->extracharge_id)}}</td>
                                        <td>{!! \App\BookingPayment::setPaymentMethodDescription($val->payment_method, $val->card_name, $val->card_type, $val->card_number, $val->bank_transfer_recipient)!!}</td>
                                        <td class="right"><strong>{{\App\Helpers\GlobalHelper::moneyFormat($val->total_payment)}}</strong></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" style="text-align: right;font-weight: bold;font-size: 14px">TOTAL PAID BILLS :
                                        {{\App\Helpers\GlobalHelper::moneyFormat($total_paid)}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <form id="form-payment" class="form-horizontal" action="{{route("$route_name.make-payment", ['id' => $header->booking_id])}}" method="post">
            {{csrf_field()}}
            <div id="error_messages" style="margin-top: 20px"></div>
            <div class="row-fluid">
                <div class="span6"></div>
                <div class="span6">
                    <div id="dp-container" class="widget-box title">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Payment Info</h5>
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
                                <div id="cc-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">Settlement</label>
                                        <div class="controls">
                                            <select id="settlement" name="settlement">
                                                <option value="0" disabled selected>Choose Settlement</option>
                                                @foreach($settlement as $key => $val)
                                                    <option @if(old('settlement') == $val['settlement_id']) selected="selected" @endif value="{{$val['settlement_id']}}">{{$val['settlement_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Type</label>
                                        <div class="controls">
                                            <input type="radio" value="1" checked name="card_type" id="cre"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="cre">Credit Card</label>
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
                                            <select id="cc_type" name="cc_type">
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
                                            <select id="bank" name="bank">
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
                                            <select id="cash_account_id" name="cash_account_id">
                                                <option value="0" selected>Choose Recipient</option>
                                                @foreach($cash_account as $key => $val)
                                                    <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Total Unpaid Amount</label>
                                    <div class="controls">
                                        <span class="big-grand-total">{{\App\Helpers\GlobalHelper::moneyFormat($total_unpaid_all)}}</span>
                                        <input type="hidden" name="total_unpaid" value="{{$total_unpaid_all}}">
                                        <input type="hidden" name="guest_id" value="{{$header->guest_id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="MAKE PAYMENT">
        </form>
    </div>
    </div>

@endsection