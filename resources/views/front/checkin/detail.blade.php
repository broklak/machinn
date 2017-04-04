@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}} Detail</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($header->checkout == 0)
        <a onclick="return confirm('Are you sure to checkout?')" class="btn-large btn-danger"
           href="{{route('checkin.checkout', ['id' => $header->booking_id])}}">CHECKOUT NOW
        </a>
        @else
            <a class="btn-large btn-info">ALREADY CHECKOUT
            </a>
        @endif
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>Detail In House Guest</h5>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-detail">
                            <tr>
                                <td class="title">Booking Code</td>
                                <td>{{$header->booking_code}}</td>
                                <td class="title">Source</td>
                                <td>{{\App\Partner::getName($header->partner_id)}}</td>
                            </tr>
                            <tr>
                                <td class="title">Nama</td>
                                <td>{{\App\Guest::getTitleName($guest->title) . ' '. $guest->first_name . ' ' . $guest->last_name}}</td>
                                <td class="title">ID Number</td>
                                <td>{{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
                            </tr>
                            <tr>
                                <td class="title">Room List</td>
                                <td>{{\App\RoomNumber::getRoomCodeList($header->room_list)}}</td>
                                <td class="title">Guest Total</td>
                                <td>Adult : {{$header->adult_num}} , Child : {{$header->child_num}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#guestInformation">Guest Information</a></li>
                            <li><a data-toggle="tab" href="#roomInformation">Room Information</a></li>
                            <li><a data-toggle="tab" href="#guestHistory">Guest History</a></li>
                            <li><a data-toggle="tab" href="#rateInformation">Rate Information</a></li>
                            <li><a data-toggle="tab" href="#billInformation">Guest Bill Information</a></li>
                            <li><a data-toggle="tab" href="#extracharge">Extra Charges</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="guestInformation" class="tab-pane active">
                            <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
                                <h5>Guest Information</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.guest_info')
                            </div>
                        </div>
                        <div id="roomInformation" class="tab-pane">
                            <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
                                <h5>Room Information</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.edit_room')
                            </div>
                        </div>
                        <div id="guestHistory" class="tab-pane">
                            <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
                                <h5>Guest History</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.guest_history')
                            </div>
                        </div>
                        <div id="rateInformation" class="tab-pane">
                            <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
                                <h5>Rate Information</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.rate_info')
                            </div>
                        </div>
                        <div id="billInformation" class="tab-pane">
                            <div class="widget-title"> <span class="icon"> <i class="icon-money"></i> </span>
                                <h5>Guest Bill Information</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.bill_info')
                            </div>
                        </div>
                        <div id="extracharge" class="tab-pane">
                            <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
                                <h5>Extra Charges</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.extracharge')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection