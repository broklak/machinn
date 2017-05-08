@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}} Report</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Choose Date Range</label>
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
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#room">Room Sales</a></li>
                            <li><a data-toggle="tab" href="#outlet">Outlet Sales</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="room" class="tab-pane active">
                            <table class="table table-bordered table-striped booking-report">
                                <thead>
                                <tr>
                                    <th>ROOM TYPE</th>
                                    <th>TOTAL ROOM SOLD</th>
                                    <th>TOTAL AMOUNT SOLD</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $total_qty = $total_amount = 0; @endphp
                                    @foreach($room as $key => $value)
                                    @php $total_qty = $total_qty + $value->total_qty @endphp
                                    @php $total_amount = $total_amount + $value->total_amount @endphp
                                    <tr>
                                        <td>{{$value->room_type_name}}</td>
                                        <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($value->total_qty)}}</td>
                                        <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($value->total_amount)}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="summary-td" style="text-align: right">TOTAL</td>
                                        <td class="summary-td" style="text-align: right">{{$total_qty}}</td>
                                        <td class="summary-td" style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_amount)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="outlet" class="tab-pane">
                            <table class="table table-bordered table-striped booking-report">
                                <thead>
                                <tr>
                                    <th>OUTLET</th>
                                    <th>TOTAL BILL</th>
                                    <th>TOTAL TAX</th>
                                    <th>TOTAL SERVICE</th>
                                    <th>TOTAL DISCOUNT</th>
                                </tr>
                                </thead>
                                <tbody>
                                 <tr>
                                     <td>Outlet Dine In</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($bill_dine)}}</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($tax_dine)}}</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($service_dine)}}</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($discount_dine)}}</td>
                                </tr>
                                 <tr>
                                     <td>Room Service</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($bill_service)}}</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($tax_service)}}</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($service_service)}}</td>
                                     <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($discount_service)}}</td>
                                 </tr>
                                <tr>
                                    <td class="summary-td" style="text-align: right">TOTAL</td>
                                    <td class="summary-td" style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_bill)}}</td>
                                    <td class="summary-td" style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_tax)}}</td>
                                    <td class="summary-td" style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_service)}}</td>
                                    <td class="summary-td" style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_discount)}}</td>
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