@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.actualArrivalReport')</a> </div>
        <h1>@lang('module.actualArrivalReport')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">@lang('web.chooseDateRange')</label>
                <div class="controls">
                    <form action="">
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input type="submit" value="@lang('web.search')" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
                <div style="float: right">
                    <a href="{{route('back.excel.arrival')}}?start={{$start}}" class="btn btn-success">@lang('web.exportCsv')</a>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#arrival">Check In</a></li>
                            <li><a data-toggle="tab" href="#departure">Check Out</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="arrival" class="tab-pane active">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('web.bookingCode')</th>
                                    <th>@lang('web.guest')</th>
                                    <th>@lang('module.roomNumber')</th>
                                    <th>@lang('web.checkinDate')</th>
                                    <th>@lang('web.checkoutDate')</th>
                                    <th>@lang('web.numberGuest')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($arrival) > 0)
                                    @php $total_room = $total_adult = $total_child = 0; @endphp
                                    @foreach($arrival as $val)
                                        <tr>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{$val->first_name .' '.$val->last_name}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                            <td>Adult : {{$val->adult_num}}, Child : {{$val->child_num}}</td>
                                        </tr>
                                        @php $total_room = $total_room + $val->total_room; @endphp
                                        @php $total_adult = $total_adult + $val->adult_num; @endphp
                                        @php $total_child = $total_child + $val->child_num; @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="summary-td" style="text-align: right">TOTAL {{strtoupper(__('web.roomBooked'))}} : {{$total_room}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="summary-td" style="text-align: right">TOTAL {{strtoupper(__('web.guest'))}} : {{strtoupper(__('web.adult'))}} ({{$total_adult}}), {{strtoupper(__('web.child'))}} ({{$total_child}})</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            {{$arrival->links()}}
                        </div>
                        <div id="departure" class="tab-pane">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('web.bookingCode')</th>
                                    <th>@lang('web.guest')</th>
                                    <th>@lang('module.roomNumber')</th>
                                    <th>@lang('web.checkinDate')</th>
                                    <th>@lang('web.checkoutDate')</th>
                                    <th>@lang('web.numberGuest')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($departure) > 0)
                                    @php $total_room = $total_adult = $total_child = 0; @endphp
                                    @foreach($departure as $val)
                                        <tr>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{$val->first_name .' '.$val->last_name}}</td>
                                            <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                            <td>Adult : {{$val->adult_num}}, Child : {{$val->child_num}}</td>
                                        </tr>
                                        @php $total_room = $total_room + $val->total_room; @endphp
                                        @php $total_adult = $total_adult + $val->adult_num; @endphp
                                        @php $total_child = $total_child + $val->child_num; @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="summary-td" style="text-align: right">TOTAL {{strtoupper(__('web.roomBooked'))}} : {{$total_room}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="summary-td" style="text-align: right">TOTAL {{strtoupper(__('web.guest'))}} : {{strtoupper(__('web.adult'))}} ({{$total_adult}}), {{strtoupper(__('web.child'))}} ({{$total_child}})</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            {{$departure->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
