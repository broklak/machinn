@extends('layout.main')

@section('title', 'Home')

@section('content')

    @php $route = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.' : '' @endphp

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{($paid) ? 'Guest Payment' : 'In House Guest'}}</h1>
    </div>
    <div class="container-fluid">
        <div class="legend-status">
            <span class="checkout-now">&nbsp;</span><span class="legend-title">Need to Checkout Now</span>
            <span class="checkout-soon">&nbsp;</span><span class="legend-title">Expected Checkout</span>
        </div>
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Booking List</h5>
                        <div class="filter-data">
                            <form action="{{route($route.'guest.inhouse')}}">
                                <input id="guest" name="guest" placeholder="Search By Guest Name" value="{{$filter['guest']}}" type="text" />
                                <input type="hidden" name="paid" value="{{$paid}}">
                                <input type="hidden" name="type" value="{{$type}}">
                                <input id="room_number" name="room_number" placeholder="Search By Room Number" value="{{$filter['room_number']}}" type="text" />
                                <input type="submit" class="btn btn-primary" value="Search">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Guest Name</th>
                                <th>Room Number</th>
                                @if($type != 'housekeep')
                                    <th>Room Plan</th>
                                @endif
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                @if($type != 'housekeep')
                                    <th>Business Source</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="checkout-{{\App\BookingRoom::validateCheckoutTime($val->checkout_date, $val->checkout)}}">
                                        <td>{{$val->booking_code}}</td>
                                        <td>{{$val->first_name .' '.$val->last_name}} <br/>({{$val->id_number}}) ({{$guest_model->getIdTypeName($val->id_type)}})</td>
                                        <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                        @if($type != 'housekeep') <td>{{\App\RoomNumber::getPlanName($val->room_plan_id)}}</td> @endif
                                        <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                        @if($type != 'housekeep')
                                            <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        @if($paid)
                                                            <li>
                                                                <a href="#" onClick="window.open('{{route('checkin.print-receipt', ['id' => $val->booking_id])}}','pagename','resizable,height=800,width=750');
                                                                    return false;"><i class="icon-money"></i> Print Receipt</a><noscript>
                                                                    You need Javascript to use the previous link or use <a href="yourpage.htm" target="_blank">New Page
                                                                    </a>
                                                                </noscript>
                                                            </li>
                                                            <li>
                                                                <a href="#" onClick="window.open('{{route('checkin.print-bill', ['id' => $val->booking_id])}}','pagename','resizable,height=900,width=950');
                                                                        return false;"><i class="icon-file-alt"></i> Print Bill</a><noscript>
                                                                    You need Javascript to use the previous link or use <a href="yourpage.htm" target="_blank">New Page
                                                                    </a>
                                                                </noscript>
                                                            </li>
                                                            {{--<li><a href=""><i class="icon-credit-card"></i> Print Receipt</a></li>--}}
                                                        @endif
                                                        @if($val->checkout == 1)
                                                            <li><a href="{{route('checkin.payment', ['id' => $val->booking_id])}}"><i class="icon-signout"></i> Payment</a></li>
                                                        @endif
                                                        <li><a href="{{route('checkin.detail', ['id' => $val->booking_id])}}"><i class="icon-file"></i> View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        @endif
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
                </div>
                {{ $link }}
            </div>
        </div>
    </div>

@endsection