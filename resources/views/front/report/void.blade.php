@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Booking Cancel History</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
            <div class="control-group">
                <label class="control-label">Choose Status</label>
                <div class="controls">
                        <select name="status" onchange="this.form.submit()">
                            <option @if($status == 0) selected @endif value="0">All Status</option>
                            <option @if($status == 3) selected @endif value="3">No Show</option>
                            <option @if($status == 4) selected @endif value="4">Cancelled</option>
                        </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Choose Date Range</label>
                <div class="controls">
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                </div>
            </div>
                <div style="float: right">
                    <a href="{{route('back.excel.void')}}?start={{$start}}&end={{$end}}" class="btn btn-success">Export to CSV</a>
                </div>
                <div style="clear: both;"></div>
            </form>
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
                                    <th>Booking Code</th>
                                    <th>Guest Name</th>
                                    <th>Business Source</th>
                                    <th>Checkin Date</th>
                                    <th>Checkout Date</th>
                                    <th>Status</th>
                                    <th>Void By</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $key => $value)
                                    <tr>
                                        <td>{{$value->booking_code}}</td>
                                        <td>{{$value->first_name.' '.$value->last_name}}</td>
                                        <td>{{$value->partner_name}}</td>
                                        <td>{{date('j F Y', strtotime($value->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($value->checkout_date))}}</td>
                                        <td>{{($value->booking_status == 3) ? 'No Show' : 'Cancelled'}}</td>
                                        <td>{{\App\User::getName($value->updated_by)}}</td>
                                    </tr>
                                @endforeach
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