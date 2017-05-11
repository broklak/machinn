@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Outlet Night Audit</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                <div class="control-group">
                    <label class="control-label">Choose Status</label>
                    <div class="controls">
                        <select name="status" onchange="this.form.submit()">
                            <option @if($status == 0) selected @endif value="0">Not Audited</option>
                            <option @if($status == 1) selected @endif value="1">Audited</option>
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
                            <form method="post" action="{{route('back.night.outlet.process')}}">
                                {{csrf_field()}}
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Bill Number</th>
                                        <th>Date</th>
                                        <th>Guest</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Audit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $key => $value)
                                        <tr>
                                            <td>{{$value->bill_number}}</td>
                                            <td>{{date('j F Y', strtotime($value->created_at))}}</td>
                                            <td>{{($value->guest_id == 0) ? 'Non Guest' : \App\Guest::getFullName($value->guest_id)}}</td>
                                            <td>{{\App\OutletTransactionHeader::getDeliveryType($value->delivery_type)}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($value->grand_total)}}</td>
                                            <td>
                                                @if($value->audited == 1)
                                                    <a onclick="return confirm('Are you sure to void audit this transaction?')"
                                                       href="{{route('back.night.outlet.void', ['boking_id' => $value->transaction_id])}}" class="btn btn-danger">Void Audit</a>
                                                @else
                                                    <input value="{{$value->transaction_id}}" type="checkbox" @if($value->audited == 1) disabled checked @endif name="audit[]">
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($status == 0)
                                        <tr>
                                            <td colspan="7" style="text-align: right"><input class="btn btn-primary" value="Make Night Audit" type="submit"></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                {{$rows->links()}}
            </div>
        </div>
    </div>
@endsection