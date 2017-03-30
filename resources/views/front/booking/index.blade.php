@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Create New {{$master_module}}</a>
        <div class="filter-data">

        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Booking List</h5>
                        <div class="filter-data">
                            <form>
                                <select name="status" id="booking-status">
                                    <option @if($filter['status'] == null || $filter['status'] == 0) selected @endif value="0">All Booking Status</option>
                                    <option @if($filter['status'] == 1) selected @endif value="1">Wait to Check In</option>
                                    <option @if($filter['status'] == 2) selected @endif value="2">Already Check In</option>
                                    <option @if($filter['status'] == 3) selected @endif value="3">No Showing</option>
                                    <option @if($filter['status'] == 4) selected @endif value="4">Void</option>
                                </select>

                                <input id="guest" name="guest" placeholder="Search By Guest Name" value="{{$filter['guest']}}" type="text" />
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
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Business Source</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->booking_code}}</td>
                                        <td>{{$val->first_name .' '.$val->last_name}} <br/>({{$val->id_number}}) ({{$guest_model->getIdTypeName($val->id_type)}})
                                            <br /><label class="label label-{{\App\Helpers\GlobalHelper::getBookingTypeLabel($val->type)}}">{{\App\Helpers\GlobalHelper::getBookingTypeName($val->type)}}</label>
                                        </td>
                                        <td>{{\App\RoomNumber::getRoomCodeList($val->room_list)}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                        <td>{{($val->partner_id == 0) ? 'Walk In' : $val->partner_name}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::getBookingStatus($val->booking_status)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" @if($val->booking_status == 4 || $val->booking_status == 3) disabled @endif class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    @if($val->booking_status != 4 && $val->booking_status != 3)
                                                        @if($val->type == 1)
                                                            <li><a href="{{route("$route_name.showdownpayment", ['id' => $val->booking_id])}}"><i class="icon-money"></i> Down Payment</a></li>
                                                        @endif
                                                        @if($val->booking_status != 2)
                                                            <li><a onclick="return confirm('Check In Booking #{{$val->booking_code}}?')" href="{{route('checkin.book', ['id' => $val->booking_id])}}">
                                                                <i class="icon-signout"></i> Check In</a>
                                                            </li>
                                                        @endif
                                                        <li><a href="{{route("$route_name.edit", ['id' => $val->booking_id])}}"><i class="icon-pencil"></i> Edit</a></li>
                                                        <li><a href="#modalVoid-{{$val->booking_id}}" data-toggle="modal" href="#"><i class="icon-remove"></i> Void</a></li>
                                                    @endif
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

    {{--MODAL--}}

    @if(count($rows) > 0)
        @foreach($rows as $val)
            <div id="modalVoid-{{$val->booking_id}}" class="modal hide">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>Void Booking #{{$val->booking_code}}</h3>
                </div>
                <div class="modal-body">
                    <form id="searchGuestForm" class="form-horizontal" method="post" action="{{route("$route_name.void", ['booking_id' => $val->booking_id])}}">
                        {{csrf_field()}}
                        <input type="hidden" name="void_type" value="{{$val->type}}">
                        <input type="hidden" name="void_guest_id" value="{{$val->guest_id}}">
                        <div id="form-search-guest" class="step">
                            <div class="control-group">
                                <label class="control-label">Guest Name</label>
                                <div class="controls">
                                    <input readonly id="void_guest_name" value="{{$val->first_name .' '.$val->last_name}}" name="void_guest_name" type="text" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Room Number</label>
                                <div class="controls">
                                    <input readonly id="void_room" value="{{\App\RoomNumber::getRoomCodeList($val->room_list)}}" name="void_room" type="text" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Down Payment Paid</label>
                                <div class="controls">
                                    <input readonly id="void_dp_paid" value="{{\App\Helpers\GlobalHelper::moneyFormat($val->down_payment)}}" name="void_dp_paid" type="text" />
                                </div>
                            </div>
                            @if($val->type == 1)
                                <div class="control-group">
                                    <label class="control-label">Refund Amount</label>
                                    <div class="controls">
                                        <input id="void_dp_refund" required value="{{\App\Helpers\GlobalHelper::moneyFormat($val->down_payment)}}" name="void_dp_refund" type="number" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Refund Method</label>
                                    <div class="controls">
                                        <select required id="payment_method" name="void_payment_method">
                                            @foreach($payment_method as $key => $val)
                                                <option @if(old('payment_method') == $val) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="control-group">
                                <label class="control-label">Void Description</label>
                                <div class="controls">
                                    <textarea name="void_desc"></textarea>
                                </div>
                            </div>
                            <div class="form-actions text-center">
                                <button type="submit" class="btn btn-danger">Void Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

@endsection