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
                                <option @if($year == $year-$x) selected @endif>{{$year - $x}}</option>
                            @endfor
                        </select>
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{$month}} {{$year}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#general">General Report</a></li>
                            <li><a data-toggle="tab" href="#active">Booking Active</a></li>
                            <li><a data-toggle="tab" href="#void">Booking Void</a></li>
                            <li><a data-toggle="tab" href="#tab4">Booking No Show</a></li>
                            <li><a data-toggle="tab" href="#tab5">Booking Check In</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="general" class="tab-pane active">
                            <table class="table table-bordered table-striped booking-report">
                                <thead>
                                    <tr>
                                        <th>SUMMARY</th>
                                        <th>BOOKING ACTIVE</th>
                                        <th>BOOKING VOID</th>
                                        <th>BOOKING NO SHOW</th>
                                        <th>BOOKING CHECKIN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Room</td>
                                        <td>{{count($activeRoomNum)}}</td>
                                        <td>{{count($voidRoomNum)}}</td>
                                        <td>{{count($noShowRoomNum)}}</td>
                                        <td>{{count($checkInRoomNum)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Night</td>
                                        <td>{{($activeNightNum == null) ? 0 : $activeNightNum}}</td>
                                        <td>{{($voidNightNum == null) ? 0 : $voidNightNum}}</td>
                                        <td>{{($noShowNightNum == null) ? 0 : $noShowNightNum}}</td>
                                        <td>{{($checkInNightNum == null) ? 0 : $checkInNightNum}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Booking</td>
                                        <td>{{$bookActiveNum}}</td>
                                        <td>{{$bookVoidNum}}</td>
                                        <td>{{$bookNoShowNum}}</td>
                                        <td>{{$bookCheckinNum}}</td>
                                    </tr>
                                    <tr>
                                        <td class="partner" colspan="5">Business Source</td>
                                    </tr>
                                    @foreach($partner as $key => $val)
                                        <tr>
                                            <td><i class="icon-share"></i> {{$val->partner_name}}</td>
                                            <td>{{\App\BookingHeader::where('booking_status', 1)->where('partner_id', $val->partner_id)->whereBetween('checkin_date', [$start, $end])->count()}}</td>
                                            <td>{{\App\BookingHeader::where('booking_status', 4)->where('partner_id', $val->partner_id)->whereBetween('checkin_date', [$start, $end])->count()}}</td>
                                            <td>{{\App\BookingHeader::where('booking_status', 3)->where('partner_id', $val->partner_id)->whereBetween('checkin_date', [$start, $end])->count()}}</td>
                                            <td>{{\App\BookingHeader::where('booking_status', 2)->where('partner_id', $val->partner_id)->whereBetween('checkin_date', [$start, $end])->count()}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="active" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest Name</th>
                                    <th>Booking Code</th>
                                    <th>Booking Date</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Business Source</th>
                                    <th>Total Night</th>
                                    <th>Total Room</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($bookActiveList) > 0)
                                    @php $i =0; @endphp
                                    @foreach($bookActiveList as $val)
                                        @php $i++; @endphp
                                        <tr class="odd gradeX">
                                            <td>{{$i}}</td>
                                            <td>{{$val->first_name .' '.$val->last_name}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                            <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                            <td>{{$val->total_night}}</td>
                                            <td>{{$val->room_num}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" style="text-align: center">No Booking Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="void" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest Name</th>
                                    <th>Booking Code</th>
                                    <th>Booking Date</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Business Source</th>
                                    <th>Total Night</th>
                                    <th>Total Room</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($bookVoidList) > 0)
                                    @php $i =0; @endphp
                                    @foreach($bookVoidList as $val)
                                        @php $i++; @endphp
                                        <tr class="odd gradeX">
                                            <td>{{$i}}</td>
                                            <td>{{$val->first_name .' '.$val->last_name}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                            <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                            <td>{{$val->total_night}}</td>
                                            <td>{{$val->room_num}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" style="text-align: center">No Booking Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="tab4" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest Name</th>
                                    <th>Booking Code</th>
                                    <th>Booking Date</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Business Source</th>
                                    <th>Total Night</th>
                                    <th>Total Room</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($bookNoShowList) > 0)
                                    @php $i =0; @endphp
                                    @foreach($bookNoShowList as $val)
                                        @php $i++; @endphp
                                        <tr class="odd gradeX">
                                            <td>{{$i}}</td>
                                            <td>{{$val->first_name .' '.$val->last_name}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                            <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                            <td>{{$val->total_night}}</td>
                                            <td>{{$val->room_num}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" style="text-align: center">No Booking Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="tab5" class="tab-pane">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest Name</th>
                                    <th>Booking Code</th>
                                    <th>Booking Date</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Business Source</th>
                                    <th>Total Night</th>
                                    <th>Total Room</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($bookCheckInList) > 0)
                                    @php $i =0; @endphp
                                    @foreach($bookCheckInList as $val)
                                        @php $i++; @endphp
                                        <tr class="odd gradeX">
                                            <td>{{$i}}</td>
                                            <td>{{$val->first_name .' '.$val->last_name}}</td>
                                            <td>{{$val->booking_code}}</td>
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                            <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                            <td>{{$val->total_night}}</td>
                                            <td>{{$val->room_num}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" style="text-align: center">No Booking Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection