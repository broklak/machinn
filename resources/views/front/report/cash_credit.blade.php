@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>
            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment' || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.down-payment') @lang('module.depositReport')
            @else @lang('module.cashCreditReport')
            @endif
        </h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">@lang('web.chooseDateRange')</label>
                <div class="controls">
                    <form>
                        <select onchange="this.form.submit()" name="month">
                            @foreach($month_list as $key => $val)
                                <option @if($month == $val) selected @endif value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                        <select onchange="this.form.submit()" name="year">
                            @for($x=0; $x < $year_list; $x++)
                                <option @if($year == $year-$x) selected @endif>{{$year - $x}}</option>
                            @endfor
                        </select>
                        <input type="submit" style="vertical-align: top" value="@lang('web.search')" class="btn btn-primary">
                    </form>
                </div>
                <div style="float: right">
                    @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment' || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.down-payment')
                        <a href="{{route('back.excel.deposit')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">@lang('web.exportCsv')</a>
                    @else
                        <a href="{{route('back.excel.cashCredit')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">@lang('web.exportCsv')</a>
                    @endif
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{$month}} {{$year}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#total">TOTAL</a></li>
                            <li><a data-toggle="tab" href="#cashfo">@lang('web.paymentMethodDescriptionCashFront')</a></li>
                            <li><a data-toggle="tab" href="#cashbo">@lang('web.paymentMethodDescriptionCashBack')</a></li>
                            <li><a data-toggle="tab" href="#credit">@lang('web.credit')</a></li>
                            <li><a data-toggle="tab" href="#bank">@lang('web.bankTransfer')</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="total" class="tab-pane active">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>{{strtoupper(__('web.date'))}}</td>
                                    <td>{{strtoupper(__('web.bookingCode'))}}</td>
                                    <td>{{strtoupper(__('web.room'))}}</td>
                                    <td>{{strtoupper(__('web.cash'))}}</td>
                                    <td>{{strtoupper(__('web.credit'))}}</td>
                                    <td>{{strtoupper(__('web.bankTransfer'))}}</td>
                                    <td>TOTAL</td>
                                    <td>MDR</td>
                                    <td>TOTAL {{strtoupper(__('web.after'))}} MDR</td>
                                    <td>{{strtoupper(__('web.receiveBy'))}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows['all']) > 0)
                                    @php $total_all = 0 @endphp
                                    @foreach($rows['all'] as $val)
                                        <tr class="odd gradeX">
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_cash)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_credit)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_bank)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}</td>
                                            <td>0</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}</td>
                                            <td>{{$val->creby}}</td>
                                        </tr>
                                        @php $total_all = $total_all + $val->total_payment @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="10" class="grand_total">TOTAL {{\App\Helpers\GlobalHelper::moneyFormat($total_all)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="14" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="cashfo" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>{{strtoupper(__('web.date'))}}</td>
                                    <td>{{strtoupper(__('web.bookingCode'))}}</td>
                                    <td>{{strtoupper(__('web.room'))}}</td>
                                    <td>TOTAL</td>
                                    <td>{{strtoupper(__('web.receiveBy'))}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows['cashfo']) > 0)
                                    @php $total_cashfo = 0 @endphp
                                    @foreach($rows['cashfo'] as $val)
                                        <tr class="odd gradeX">
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}</td>
                                            <td>{{$val->creby}}</td>
                                        </tr>
                                        @php $total_cashfo = $total_cashfo + $val->total_payment @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="10" class="grand_total">TOTAL {{\App\Helpers\GlobalHelper::moneyFormat($total_cashfo)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="14" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div id="cashbo" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>{{strtoupper(__('web.date'))}}</td>
                                    <td>{{strtoupper(__('web.bookingCode'))}}</td>
                                    <td>{{strtoupper(__('web.room'))}}</td>
                                    <td>TOTAL</td>
                                    <td>{{strtoupper(__('web.receiveBy'))}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows['cashbo']) > 0)
                                    @php $total_cashfo = 0 @endphp
                                    @foreach($rows['cashbo'] as $val)
                                        <tr class="odd gradeX">
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}</td>
                                            <td>{{$val->creby}}</td>
                                        </tr>
                                        @php $total_cashfo = $total_cashfo + $val->total_payment @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="10" class="grand_total">TOTAL {{\App\Helpers\GlobalHelper::moneyFormat($total_cashfo)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="14" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div id="credit" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>{{strtoupper(__('web.date'))}}</td>
                                    <td>{{strtoupper(__('web.bookingCode'))}}</td>
                                    <td>{{strtoupper(__('web.room'))}}</td>
                                    <td>{{strtoupper(__('web.cardType'))}}</td>
                                    <td>BANK</td>
                                    <td>TOTAL</td>
                                    <td>{{strtoupper(__('web.receiveBy'))}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows['credit']) > 0)
                                    @php $total_credit = 0 @endphp
                                    @foreach($rows['credit'] as $val)
                                        <tr class="odd gradeX">
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{$val->cc_type_name}}</td>
                                            <td>{{$val->bank_name}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}</td>
                                            <td>{{$val->creby}}</td>
                                        </tr>
                                        @php $total_credit = $total_credit + $val->total_payment @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="10" class="grand_total">TOTAL {{\App\Helpers\GlobalHelper::moneyFormat($total_credit)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="14" style="text-align: center">{{strtoupper(__('msg.noData'))}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div id="bank" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>{{strtoupper(__('web.date'))}}</td>
                                    <td>{{strtoupper(__('web.bookingCode'))}}</td>
                                    <td>{{strtoupper(__('web.room'))}}</td>
                                    <td>{{strtoupper(__('web.cashBankAccount'))}}</td>
                                    <td>TOTAL</td>
                                    <td>{{strtoupper(__('web.receiveBy'))}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows['bank']) > 0)
                                    @php $total_bank = 0 @endphp
                                    @foreach($rows['bank'] as $val)
                                        <tr class="odd gradeX">
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{$val->cash_account_name}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_payment)}}</td>
                                            <td>{{$val->creby}}</td>
                                        </tr>
                                        @php $total_bank = $total_bank + $val->total_payment @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="10" class="grand_total">TOTAL {{\App\Helpers\GlobalHelper::moneyFormat($total_bank)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="14" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
