@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Booking List</h5>
                        <div class="filter-data">
                            <form>
                                <input id="guest" name="guest" placeholder="Search By Guest Name" value="{{$filter['guest']}}" type="text" />
                                <input id="room_number" name="room_number" placeholder="Search By Room Number" value="{{$filter['room_number']}}" type="text" />
                                <input type="submit" class="btn btn-primary" value="Search">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Guest Name</th>
                                <th>Room Number</th>
                                <th>Room Plan</th>
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                <th>Business Source</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->booking_code}}</td>
                                        <td>{{$val->first_name .' '.$val->last_name}} <br/>({{$val->id_number}}) ({{$guest_model->getIdTypeName($val->id_type)}})</td>
                                        <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                        <td>{{\App\RoomNumber::getPlanName($val->room_plan_id)}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                        <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    @if($val->checkout == 1)
                                                        <li><a href="{{route('checkin.payment', ['id' => $val->booking_id])}}"><i class="icon-signout"></i> Payment</a></li>
                                                    @endif
                                                    <li><a href="{{route('checkin.detail', ['id' => $val->booking_id])}}"><i class="icon-file"></i> View Detail</a></li>
                                                </ul>
                                            </div>
                                        </td>
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