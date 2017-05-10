@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Actual Room Occupied Report</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Choose Date</label>
                <div class="controls">
                    <form action="">
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <h5></h5>
                    </div>
                    <div class="widget-content">
                        <div class="tab-pane active">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total Room Sold</th>
                                    <th>Total Guest</th>
                                    <th>Total Bill</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $total_room = $total_bill = $total_guest = 0;  @endphp
                                    @for($x=0; $x <= $day; $x++)
                                    <tr>
                                        <td>{{date('j F Y', strtotime("$start + $x days"))}}</td>
                                        <td>{{\App\BookingRoom::getTotalRoom(date('Y-m-d', strtotime("$start + $x days")))}}</td>
                                        <td>{{$rows[$x]['total_guest']}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport(\App\BookingRoom::getTotalRatePerDay(date('Y-m-d', strtotime("$start + $x days"))))}}</td>
                                    </tr>
                                        @php $total_room = $total_room + \App\BookingRoom::getTotalRoom(date('Y-m-d', strtotime("$start + $x days")))   @endphp
                                        @php $total_guest = $total_guest + $rows[$x]['total_guest']  @endphp
                                        @php $total_bill = $total_bill + \App\BookingRoom::getTotalRatePerDay(date('Y-m-d', strtotime("$start + $x days")))   @endphp
                                    @endfor
                                    <tr>
                                        <td class="summary-td">TOTAL</td>
                                        <td class="summary-td">{{$total_room}}</td>
                                        <td class="summary-td">{{$total_guest}}</td>
                                        <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_bill)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection