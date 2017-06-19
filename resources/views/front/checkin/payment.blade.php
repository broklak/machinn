@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{strtoupper(__('web.guestBill'))}} #<b>{{$bill_number}}</b></h1>
    </div>
    <div class="container-fluid">
        @if($header->payment_status == 3)
            <label class="label large label-success">{{strtoupper(__('web.paid'))}}</label>
        @else
            <label class="label large label-important">{{strtoupper(__('web.unpaid'))}}</label>
        @endif
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box title">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.detailInhouse')</h5>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-detail">
                            <tr>
                                <td class="title">@lang('web.bookingCode')</td>
                                <td>{{$header->booking_code}}</td>
                                <td class="title">@lang('web.source')</td>
                                <td>{{\App\Partner::getName($header->partner_id)}}</td>
                            </tr>
                            <tr>
                                <td class="title">@lang('web.name')</td>
                                <td>{{\App\Guest::getTitleName($guest->title) . ' '. $guest->first_name . ' ' . $guest->last_name}}</td>
                                <td class="title">@lang('web.idNumber')</td>
                                <td>{{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
                            </tr>
                            <tr>
                                <td class="title">@lang('web.room')</td>
                                <td>{{\App\RoomNumber::getRoomCodeList($header->room_list)}}</td>
                                <td class="title">@lang('web.numberGuest')</td>
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
                        <h5>@lang('web.roomBills')</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{strtoupper(__('web.date'))}}</th>
                                <th>{{strtoupper(__('module.roomNumber'))}}</th>
                                <th>{{strtoupper(__('web.roomRate'))}}</th>
                                <th>{{strtoupper(__('web.roomPlanPrice'))}}</th>
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
                                <td colspan="6" style="text-align: right;font-weight: bold;font-size: 14px">{{strtoupper(__('web.totalUnpaidRoomBills'))}} :
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
                        <h5>@lang('web.extrachargeBills')</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{strtoupper(__('web.date'))}}</th>
                                <th>{{strtoupper(__('web.room'))}}</th>
                                <th>{{strtoupper(__('web.extracharge'))}}</th>
                                <th>{{strtoupper(__('web.price'))}}</th>
                                <th>{{strtoupper(__('web.qty'))}}</th>
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
                                <td colspan="8" style="text-align: right;font-weight: bold;font-size: 14px">{{strtoupper(__('web.totalUnpaidExtrachargeBills'))}} : <span id="grand_total_text">
                                        {{\App\Helpers\GlobalHelper::moneyFormat($total_unpaid_extra)}}</span>
                                    <input type="hidden" name="grand_total" value="{{$total_unpaid_extra}}" id="grand_total">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="widget-box title">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.restoBills')</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{strtoupper(__('web.date'))}}</th>
                                <th>{{strtoupper(__('web.room'))}}</th>
                                <th>{{strtoupper(__('web.itemMenu'))}}</th>
                                <th>DISCOUNT</th>
                                <th>{{strtoupper(__('web.tax'))}}</th>
                                <th>{{strtoupper(__('web.service'))}}</th>
                                <th>TOTAL</th>
                            </tr>
                            </thead>
                            <tbody id="list-data">
                            @foreach($resto as $key => $value)
                                <tr>
                                    <td>{{date('j F Y', strtotime($value->created_at))}}</td>
                                    <td>{{\App\RoomNumber::getCode($value->room_id)}}</td>
                                    <td>{!! \App\OutletTransactionHeader::getDetailResto($value->transaction_id) !!}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->total_discount)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->total_tax)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->total_service)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->grand_total)}}</td>
                                    <input type="hidden" name="resto_transaction[]" value="{{$value->transaction_id}}" />
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="8" style="text-align: right;font-weight: bold;font-size: 14px">{{strtoupper(__('web.totalUnpaidRestoBills'))}} : <span id="grand_total_text">
                                        {{\App\Helpers\GlobalHelper::moneyFormat($total_unpaid_resto)}}</span>
                                    <input type="hidden" name="grand_total_resto" value="{{$total_unpaid_resto}}" id="grand_total_resto">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($payment) > 0)
                    <div class="widget-box title">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>@lang('web.paidBills')</h5>
                        </div>
                        <div class="widget-content tab-content">
                            <table class="table table-bordered table-invoice-full">
                                <thead>
                                <tr>
                                    <th class="head0">@lang('web.date')</th>
                                    <th class="head1">@lang('web.desc')</th>
                                    <th class="head0">@lang('web.paymentMethod')</th>
                                    <th class="head0 right">@lang('web.amount')</th>
                                    <th class="head0">@lang('web.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment as $key => $val)
                                    <tr>
                                        <td>{{date('j F Y', strtotime($val['created_at']))}}</td>
                                        <td>{{\App\BookingPayment::setDescription($val->type, $val->extracharge_id, $val->deposit)}}</td>
                                        <td>{!! \App\BookingPayment::setPaymentMethodDescription($val->payment_method, $val->card_name, $val->card_type, $val->card_number, $val->bank_transfer_recipient)!!}</td>
                                        <td class="right"><strong>{{\App\Helpers\GlobalHelper::moneyFormat($val->total_payment)}}</strong></td>
                                        <td>
                                        @if($val->deposit == 1 && !$refundDeposit)
                                            <a href="#modalRefund" class="btn btn-success" data-toggle="modal">@lang('web.refund')</a>
                                                <div id="modalRefund" class="modal hide">
                                                    <div class="modal-header">
                                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                                        <h3>@lang('web.refundDeposit')</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" id="refundForm" method="post" action="{{route("$route_name.refund-deposit", ['bookingPaymentId' => $val->booking_payment_id])}}">
                                                            {{csrf_field()}}
                                                            <div id="form-search-guest" class="step">
                                                                <div class="control-group">
                                                                    <label class="control-label">Total Deposit</label>
                                                                    <div class="controls">
                                                                        <input value="{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}" readonly name="text_deposit" type="text" required />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">@lang('web.refundAmount')</label>
                                                                    <div class="controls">
                                                                        <input onkeyup="formatMoney($(this))" id="refund-amount" name="refund_amount" type="text" required />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">@lang('web.desc')</label>
                                                                    <div class="controls">
                                                                        <textarea name="desc">

                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-actions text-center">
                                                                    <input type="hidden" id="total_deposit" name="total_deposit" value="{{$val->total_payment}}">
                                                                    <button type="submit" class="btn btn-success">@lang('web.refundDeposit')</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                        @elseif($val->deposit == 1 && $refundDeposit)
                                            <label class="label label-success">@lang('web.refunded')</label>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" style="text-align: right;font-weight: bold;font-size: 14px">{{strtoupper(__('web.totalPaidBills'))}} :
                                        {{\App\Helpers\GlobalHelper::moneyFormat($total_paid)}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if(!empty($deposit))
                <div class="widget-box title">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Deposit</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('web.depositAmount')</th>
                                <th>@lang('web.refundAmount')</th>
                                <th>@lang('web.depositKept')</th>
                                <th>@lang('web.desc')</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($deposit->amount)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($deposit->refund_amount)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($deposit->amount - $deposit->refund_amount)}}</td>
                                    <td>{{$deposit->desc}}</td>
                                    <td>
                                        @if($deposit->status == 0)
                                            <a href="#modalRefund" class="btn btn-success" data-toggle="modal">@lang('web.refund')</a>
                                            <div id="modalRefund" class="modal hide">
                                                <div class="modal-header">
                                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                                    <h3>@lang('web.refundDeposit')</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" id="refundForm" method="post" action="{{route("$route_name.refund-deposit", ['depositId' => $deposit->id])}}">
                                                        {{csrf_field()}}
                                                        <div id="form-search-guest" class="step">
                                                            <div class="control-group">
                                                                <label class="control-label">Total Deposit</label>
                                                                <div class="controls">
                                                                    <input value="{{\App\Helpers\GlobalHelper::moneyFormatReport($deposit->amount)}}" readonly name="text_deposit" type="text" required />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">@lang('web.refundAmount')</label>
                                                                <div class="controls">
                                                                    <input onkeyup="formatMoney($(this))" id="refund-amount" name="refund_amount" type="text" required />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">@lang('web.desc')</label>
                                                                <div class="controls">
                                                                        <textarea name="desc">

                                                                        </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-actions text-center">
                                                                <input type="hidden" id="total_deposit" name="total_deposit" value="{{$deposit->amount}}">
                                                                <button type="submit" class="btn btn-success">@lang('web.refundDeposit')</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <label class="label label-success">{{strtoupper(__('web.refunded'))}}</label>
                                        @endif
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
                            <h5>@lang('web.paymentInfo')</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <input type="hidden" id="need_dp" />
                                <div class="control-group">
                                    <label class="control-label">@lang('web.paymentMethod')</label>
                                    <div class="controls">
                                        <select id="payment_method" name="payment_method">
                                            <option value="0" disabled selected>@lang('web.choose')</option>
                                            @foreach($payment_method as $key => $val)
                                                <option @if(old('payment_method') == $val) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="cc-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.bookingPaymentDescriptionSettlement')</label>
                                        <div class="controls">
                                            <select id="settlement" name="settlement">
                                                <option value="0" disabled selected>@lang('web.choose')</option>
                                                @foreach($settlement as $key => $val)
                                                    <option @if(old('settlement') == $val['settlement_id']) selected="selected" @endif value="{{$val['settlement_id']}}">{{$val['settlement_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.cardType')</label>
                                        <div class="controls">
                                            <input type="radio" value="1" checked name="card_type" id="cre"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="cre">Credit Card</label>
                                            <input type="radio" value="2" name="card_type" id="deb"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="deb">Debit Card</label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.cardNumber')</label>
                                        <div class="controls">
                                            <input value="{{old('card_number')}}" id="card_number" type="text" name="card_number" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.cardHolder')</label>
                                        <div class="controls">
                                            <input value="{{old('card_holder')}}" id="card_holder" type="text" name="card_holder" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.cardExpired')</label>
                                        <div class="controls double-select">
                                            <select class="month-select" name="month">
                                                @foreach($month as $key => $val)
                                                    <option value="{{$key}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                            <select class="year-select" name="year">
                                                @for($x=0; $x < $year_list; $x++)
                                                    <option>{{date('Y') + $x}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.ccType')</label>
                                        <div class="controls">
                                            <select id="cc_type" name="cc_type">
                                                <option value="0" selected>@lang('web.choose')</option>
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
                                                <option value="0" selected>@lang('web.choose')</option>
                                                @foreach($bank as $key => $val)
                                                    <option @if(old('bank') == $val['bank_id']) selected="selected" @endif value="{{$val['bank_id']}}">{{$val['bank_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="bt-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.accountRecipient')</label>
                                        <div class="controls">
                                            <select id="cash_account_id" name="cash_account_id">
                                                <option value="0" selected>@lang('web.choose')</option>
                                                @foreach($cash_account as $key => $val)
                                                    <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.totalUnpaid')</label>
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
            @if($header->payment_status != 3)
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="MAKE PAYMENT">
            @else
                <a href="#" onClick="window.open('{{route('checkin.print-receipt', ['id' => $header->booking_id])}}','pagename','resizable,height=800,width=750');
                        return false;" class="btn btn-success">{{strtoupper(__('web.printReceipt'))}}</a><noscript>
                    You need Javascript to use the previous link or use <a href="yourpage.htm" target="_blank">New Page
                    </a>
                </noscript>
            @endif
        </form>
    </div>
    </div>

@endsection
