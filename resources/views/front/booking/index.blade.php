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
                                    <option @if($filter['status'] == 1) selected @endif value="1">Active</option>
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
                                    <th>Guest Name</th>
                                    <th>Handphone Number</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Business Source</th>
                                    <th>Type</th>
                                    <th>Down Payment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->first_name .' '.$val->last_name}} <br/>({{$val->id_number}}) ({{$guest_model->getIdTypeName($val->id_type)}})</td>
                                        <td>{{$val->handphone}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                        <td>{{date('j F Y', strtotime($val->checkout_date))}}</td>
                                        <td>{{$val->partner_name}}</td>
                                        <td>{{\App\BookingHeader::getBookingTypeName($val->type)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->down_payment)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#"><i class="icon-money"></i> Down Payment</a></li>
                                                    <li><a href="#"><i class="icon-signout"></i> Check In</a></li>
                                                    <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                                                    <li><a href="#"><i class="icon-remove"></i> Void</a></li>
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