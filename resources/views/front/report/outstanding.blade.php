@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Outstanding Bill</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Choose Date</label>
                <div class="controls">
                    <form action="">
                        <select name="status" onchange="this.form.submit()">
                            <option @if($status == 0) selected @endif value="0">All Status</option>
                            <option @if($status == 2) selected @endif value="2">In House Guest</option>
                            <option @if($status == 1) selected @endif value="1">Booking</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5></h5>
                    </div>
                    <div class="widget-content">
                        <div class="tab-pane active">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Guest Name</th>
                                    <th>Business Source</th>
                                    <th>Checkin Date</th>
                                    <th>Checkout Date</th>
                                    <th>Total Bill</th>
                                    <th>Total Paid</th>
                                    <th>Total Outstanding</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0;  @endphp
                                    @foreach($rows as $key => $value)
                                    <tr>
                                        <td>{{$value->booking_code}}</td>
                                        <td>{{$value->first_name.' '.$value->last_name}}</td>
                                        <td>{{$value->partner_name}}</td>
                                        <td>{{date('j F Y', strtotime($value->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($value->checkout_date))}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($value->grand_total + $value->total_extra)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($value->total_paid)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport(($value->grand_total + $value->total_extra) - $value->total_paid)}}</td>
                                        <td>{{($value->booking_status == 1) ? 'Booking' : 'In House Guest'}}</td>
                                    </tr>
                                        @php $total = $total + (($value->grand_total + $value->total_extra) - $value->total_paid) @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="7" style="text-align: right" class="summary-td">TOTAL OUTSTANDING</td>
                                        <td colspan="2" class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormatReport($total)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$rows->links()}}
            </div>
        </div>
    </div>
@endsection