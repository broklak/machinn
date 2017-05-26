@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Guest Bill {{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Choose Report Time</label>
                <div class="controls">
                    <form>
                        <select onchange="this.form.submit()" name="month">
                            @foreach($month_list as $key => $val)
                                <option @if($month == $val) selected @endif value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                        <select onchange="this.form.submit()" name="year">
                            @for($x=0; $x < $year_list; $x++)
                                <option @if($year == date('Y')-$x) selected @endif>{{date('Y') - $x}}</option>
                            @endfor
                        </select>
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
                <div style="float: right">
                    <a href="{{route('back.excel.guestBill')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">Export to CSV</a>
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
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th rowspan="2">BOOKING CODE</th>
                                <th rowspan="2">GUEST</th>
                                <th rowspan="2">ROOM</th>
                                <th rowspan="2">CHECK IN</th>
                                <th rowspan="2">CHECK OUT</th>
                                <th colspan="2">GUEST BILL</th>
                                <th colspan="3">PAYMENT</th>
                                <th rowspan="2">REFUND</th>
                                <th rowspan="2">TOTAL</th>
                                <th rowspan="2">CHECK IN BY</th>
                                <th rowspan="2">CHECK OUT BY</th>
                            </tr>
                            <tr>
                                <th>ROOM</th>
                                <th>EXTRACHARGE</th>
                                <th>CASH</th>
                                <th>CREDIT CARD</th>
                                <th>BANK TRANSFER</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->booking_code}}</td>
                                        <td>{{$val->first_name .' '.$val->last_name}} <br/> <span style="font-style: italic">{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</span></td>
                                        <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->grand_total)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->extra)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_cash)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_credit)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_bank)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->refund)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_received)}}</td>
                                        <td>{{$val->creby}}</td>
                                        <td>{{$val->modby}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="14" style="text-align: center">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $link }}
            </div>
        </div>
    </div>

@endsection