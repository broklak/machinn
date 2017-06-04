@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = 'resto.pos'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Resto POS</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <form>
                        <input placeholder="Input Bill Number" value="{{$filter['bill_number']}}" name="bill_number" type="text">
                        <select onchange="this.form.submit()" name="status">
                            <option @if($filter['status'] == 0) selected @endif value="0">All Status</option>
                            <option @if($filter['status'] == 1) selected @endif value="1">Draft</option>
                            <option @if($filter['status'] == 2) selected @endif value="2">Billed</option>
                            <option @if($filter['status'] == 3) selected @endif value="3">Paid</option>
                        </select>
                        <select onchange="this.form.submit()" name="delivery_type">
                            <option @if($filter['delivery_type'] == 0) selected @endif value="0">All Outlet</option>
                            <option @if($filter['delivery_type'] == 1) selected @endif value="1">Dine In</option>
                            <option @if($filter['delivery_type'] == 2) selected @endif value="2">Room Service</option>
                        </select>
                        <label>Date Range</label>
                        <input value="{{$filter['start']}}" id="checkin" type="text" name="start" /> TO
                        <input value="{{$filter['end']}}" id="checkout" type="text" name="end" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary" value="Search">
                    </form>
                </div>
            </div>
        </div>
        <a class="btn btn-success" href="{{route("$route_name.create")}}">Add New Transaction</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Bill Number</th>
                                    <th>Date</th>
                                    <th>Outlet</th>
                                    <th>Customer Name</th>
                                    <th>Item</th>
                                    <th>Total Bill</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->bill_number}}</td>
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{\App\OutletTransactionHeader::getDeliveryType($val->delivery_type)}}</td>
                                        <td>{{($val->guest_id == 0) ? 'Non Guest' : \App\Guest::getFullName($val->guest_id)}}</td>
                                        <td>{!! \App\OutletTransactionHeader::getDetailResto($val->transaction_id) !!}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->grand_total)}}</td>
                                        <td>{{\App\OutletTransactionDetail::getStatusName($val->status)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn dropdown-toggle">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->transaction_id])}}" title="View Detail">
                                                            <i class="icon-file" aria-hidden="true"></i> View Detail
                                                        </a>
                                                    </li>
                                                    @if($val->status == 1)
                                                        <li><a onclick="return confirm('You will delete bill {{$val->bill_number}}, continue?')" href="{{route($route_name.'.change-status', ['id' => $val->transaction_id, 'status' => 4])}}">
                                                                <i class="icon-remove"></i>Delete Transaction</a>
                                                        </li>
                                                    @endif
                                                    @if($val->status == 2)
                                                        <li><a onclick="return confirm('You will void billed {{$val->bill_number}}, continue?')" href="{{route($route_name.'.change-status', ['id' => $val->transaction_id, 'status' => 1])}}">
                                                                <i class="icon-remove"></i>Void Billed</a>
                                                        </li>
                                                    @endif
                                                    @if($val->status == 3)
                                                        <li><a onclick="return confirm('You will void payment on bill {{$val->bill_number}}, continue?')" href="{{route($route_name.'.change-status', ['id' => $val->transaction_id, 'status' => 2])}}">
                                                                <i class="icon-remove"></i>Void Payment</a>
                                                        </li>
                                                    @endif
                                                    @if($val->status != 1)
                                                        <li>
                                                            <a href="#" onClick="window.open('{{route('resto.pos.print-receipt', ['id' => $val->transaction_id])}}','pagename','resizable,height=500,width=280');
                                                                    return false;"><i class="icon-money"></i> Print Receipt</a><noscript>
                                                                You need Javascript to use the previous link or use <a href="yourpage.htm" target="_blank">New Page
                                                                </a>
                                                            </noscript>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" style="text-align: center">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection