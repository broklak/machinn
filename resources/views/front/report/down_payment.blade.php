@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>
            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment' || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.down-payment') Deposit
            @else Cash and Credit
            @endif
                {{$master_module}}
        </h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                <div class="control-group">
                    <label class="control-label">Choose Status</label>
                    <div class="controls">
                        <select onchange="this.form.submit()" name="status">
                            <option @if($filter['status'] == -1) selected @endif value="-1">All Status</option>
                            <option @if($filter['status'] == 0) selected @endif value="0">Not Refunded</option>
                            <option @if($filter['status'] == 1) selected @endif value="1">Refunded</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Choose Report Time</label>
                    <div class="controls">
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
                            <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <div style="float: right">
                @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment' || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.down-payment')
                    <a href="{{route('back.excel.deposit')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">Export to CSV</a>
                @else
                    <a href="{{route('back.excel.cashCredit')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">Export to CSV</a>
                @endif
            </div>
            <div style="clear: both;"></div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{$month}} {{$year}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content tab-content">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Deposit Amount</th>
                                <th>Refund Amount</th>
                                <th>Deposit Kept</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $total = 0; @endphp
                            @foreach($rows as $key => $value)
                                <tr>
                                    <td>{{$value->booking_code}}</td>
                                    <td>{{date('j F Y', strtotime($value->created_at))}}</td>
                                    <td>{!! ($value->status == 1) ? 'Refunded by <b>'.$value->refunded_by.'</b>' : 'Not Refunded' !!}</td>
                                    <td>{{$value->desc}}</td>
                                    <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormat($value->amount)}}</td>
                                    <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormat($value->refund_amount)}}</td>
                                    <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormat($value->total_kept)}}</td>
                                </tr>
                                @php $total = $total + $value->total_kept; @endphp
                            @endforeach
                            <tr>
                                <td style="text-align: right" class="summary-td" colspan="6">TOTAL</td>
                                <td style="text-align: right" class="summary-td">
                                    {{\App\Helpers\GlobalHelper::moneyFormat($total)}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$rows->links()}}
            </div>
        </div>
    </div>
@endsection