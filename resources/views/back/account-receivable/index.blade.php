@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                {{--<div class="control-group">--}}
                    {{--<label class="control-label">Choose Approval Status</label>--}}
                    {{--<div class="controls">--}}
                        {{--<select name="status" onchange="this.form.submit()">--}}
                            {{--<option @if($status == 0) selected @endif value="0">Not Approved</option>--}}
                            {{--<option @if($status == 1) selected @endif value="1">Approved</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="control-group">
                    <label class="control-label">Choose Payment Status</label>
                    <div class="controls">
                        <select name="paid" onchange="this.form.submit()">
                            <option @if($paid == -1) selected @endif value="-1">All Status</option>
                            <option @if($paid == 0) selected @endif value="0">Unpaid</option>
                            <option @if($paid == 1) selected @endif value="1">Paid</option>
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
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New {{$master_module}}</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Source</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{$val->desc}}</td>
                                        <td>{{\App\Partner::getName($val->partner_id)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->amount)}}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->paid, 'Paid')!!}</td>
                                        {{--<td>--}}
                                            {{--@if($val->paid == 0)--}}
                                                {{--<a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>--}}
                                                {{--<a onclick="return confirm('You will delete {{$val->invoice_number}}, continue? ')"--}}
                                                   {{--class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->id])}}"--}}
                                                   {{--title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete--}}
                                                {{--</a>--}}
                                            {{--@endif--}}
                                            {{--@if($val->status == 0)--}}
                                                {{--<a onclick="return confirm('You will approve {{$val->invoice_number}}, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->id, 'status' => $val->status])}}"><i class="icon-check" aria-hidden="true"></i> Set Approved</a>--}}
                                            {{--@else--}}
                                                {{--<a onclick="return confirm('You will unapprove {{$val->invoice_number}}, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->id, 'status' => $val->status])}}"><i class="icon-remove" aria-hidden="true"></i> Set Unapproved</a>--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center">No Data Found</td>
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