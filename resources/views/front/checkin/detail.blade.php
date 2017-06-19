@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>@lang('module.bookingDetail')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($header->checkout == 0)
        <a onclick="return confirm('Are you sure to checkout?')" class="btn-large btn-danger"
           href="{{route('checkin.checkout', ['id' => $header->booking_id])}}">CHECKOUT {{strtoupper(__('web.now'))}}
        </a>
        @else
            <a class="btn-large btn-info">{{strtoupper(__('web.already'))}} CHECKOUT
            </a>
        @endif
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>@lang('web.detailInhouse')</h5>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-detail">
                            <tr>
                                <td class="title">@lang('web.bookingCode')</td>
                                <td>{{$header->booking_code}}</td>
                                <td class="title">@lang('web.source')</td>
                                <td>{{\App\Partner::getName($header->partner_id)}}</td>
                            </tr>
                            <tr>
                                <td class="title">@lang('web.name')</td>
                                <td>{{\App\Guest::getTitleName($guest->title) . ' '. $guest->first_name . ' ' . $guest->last_name}}</td>
                                <td class="title">@lang('web.idNumber')</td>
                                <td>{{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
                            </tr>
                            <tr>
                                <td class="title">@lang('web.room')</td>
                                <td>{{\App\RoomNumber::getRoomCodeList($header->room_list)}}</td>
                                <td class="title">@lang('web.numberGuest')</td>
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
                            <li @if($tab == 'guest') class="active" @endif><a data-toggle="tab" href="#guestInformation">@lang('web.guestInfo')</a></li>
                            <li @if($tab == 'room') class="active" @endif><a data-toggle="tab" href="#roomInformation">@lang('web.roomInfo')</a></li>
                            <li @if($tab == 'history') class="active" @endif><a data-toggle="tab" href="#guestHistory">@lang('web.guestHistory')</a></li>
                            <li @if($tab == 'rate') class="active" @endif><a data-toggle="tab" href="#rateInformation">@lang('web.rateInfo')</a></li>
                            <li @if($tab == 'bill') class="active" @endif><a  data-toggle="tab" href="#billInformation">@lang('web.guestBillInfo')</a></li>
                            <li @if($tab == 'extra') class="active" @endif><a data-toggle="tab" href="#extracharge">@lang('web.bookingPaymentDescriptionExtra')</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="guestInformation" class="tab-pane @if($tab == 'guest') active @endif">
                            <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
                                <h5>@lang('web.guestInfo')</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.guest_info')
                            </div>
                        </div>
                        <div id="roomInformation" class="tab-pane @if($tab == 'room') active @endif">
                            <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
                                <h5>@lang('web.roomInfo')</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.edit_room')
                            </div>
                        </div>
                        <div id="guestHistory" class="tab-pane @if($tab == 'history') active @endif">
                            <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
                                <h5>@lang('web.guestHistory')</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.guest_history')
                            </div>
                        </div>
                        <div id="rateInformation" class="tab-pane @if($tab == 'rate') active @endif">
                            <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
                                <h5>@lang('web.rateInfo')</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.rate_info')
                            </div>
                        </div>
                        <div id="billInformation" class="tab-pane @if($tab == 'bill') active @endif">
                            <div class="widget-title"> <span class="icon"> <i class="icon-money"></i> </span>
                                <h5>@lang('web.guestBillInfo')</h5>
                            </div>
                            <div class="widget-content">
                                @include('front.checkin.bill_info')
                            </div>
                        </div>
                        <div id="extracharge" class="tab-pane @if($tab == 'extra') active @endif">
                            <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
                                <h5>@lang('web.bookingPaymentDescriptionExtra')</h5>
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
