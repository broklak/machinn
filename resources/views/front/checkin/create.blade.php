@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Create {{$master_module}}</a> </div>
        <h1>Check In</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        <div id="error_messages" style="margin-top: 20px">

        </div>
        <form id="form-booking" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
            {{csrf_field()}}
            <div class="row-fluid">
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Check In</h5>
                        </div>
                        <div class="widget-content nopadding">
                                <div id="form-wizard-1" class="step">
                                    <div class="control-group">
                                        <label class="control-label">@lang('module.roomPlan')</label>
                                        <div class="controls">
                                            <select id="room_plan_id" name="room_plan_id">
                                                <option value="0" disabled selected>@lang('web.choose')</option>
                                                @foreach($plan as $key => $val)
                                                    <option @if(old('room_plan_id') == $val['room_plan_id']) selected="selected" @endif value="{{$val['room_plan_id']}}">{{$val['room_plan_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.source')</label>
                                        <div class="controls">
                                            <input readonly value="Walk In" id="source" type="text" name="partner_id" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.checkinDate')</label>
                                        <div class="controls">
                                            <input value="{{date('Y-m-d')}}" id="checkin" type="text" name="checkin_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.checkoutDate')</label>
                                        <div class="controls">
                                            <input id="checkout" type="text" name="checkout_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.adultNumbers')</label>
                                        <div class="controls">
                                            <input value="2" max="2" id="adult" type="number" name="adult_num" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.childNumbers')</label>
                                        <div class="controls">
                                            <input value="0" max="2" id="child" type="number" name="child_num" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('module.banquet')</label>
                                        <div class="controls">
                                            <input type="radio" @if(old('is_banquet') == 0) checked @endif value="0" name="is_banquet" id="no_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no_ban">No</label>
                                            <input type="radio" @if(old('is_banquet') == 1) checked @endif value="1" name="is_banquet" id="yes_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes_ban">Yes</label>
                                        </div>
                                    </div>
                                    <div id="banquet-container" class="hide">
                                        <div class="control-group">
                                            <label class="control-label">@lang('module.banquetTime')</label>
                                            <div class="controls">
                                                <select id="banquet_time_id" name="banquet_time_id">
                                                    <option value="0" disabled selected>@lang('web.choose')</option>
                                                    @foreach($banquet_time as $key => $val)
                                                        <option @if(old('banquet_time_id') == $val['banquet_id']) selected="selected" @endif value="{{$val['banquet_id']}}">{{$val['banquet_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('module.banquetEvent')</label>
                                            <div class="controls">
                                                <select id="banquet_event_id" name="banquet_event_id">
                                                    <option value="0" disabled selected>@lang('web.choose')</option>
                                                    @foreach($banquet_event as $key => $val)
                                                        <option @if(old('banquet_event_id') == $val['event_id']) selected="selected" @endif value="{{$val['event_id']}}">{{$val['event_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.eventName')</label>
                                            <div class="controls">
                                                <input value="{{old('banquet_event_name')}}" type="text" name="banquet_event_name" />
                                            </div>
                                        </div>
                                        <input type="hidden" id="banquet" name="banquet" value="{{old('banquet')}}">
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('module.roomNumber')</label>
                                        <div class="controls">
                                            <div id="selectedRoomContainer" style="margin-bottom: 15px"></div>
                                            <a href="#modalSelectRoom" data-toggle="modal" class="btn btn-info">@lang('web.choose') @lang('web.room')</a>
                                            <input type="hidden" name="room_number" id="room_number">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.notes')</label>
                                        <div class="controls">
                                            <textarea name="notes"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.guest')</label>
                                        <div class="controls">
                                            <a href="#modalFindGuest" data-toggle="modal" class="btn btn-inverse">@lang('web.findGuest')</a>
                                            <a href="#" id="createGuestButton" data-toggle="modal" class="btn btn-primary">@lang('web.addButton') @lang('web.guest')</a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.totalRoomRates')</label>
                                        <div class="controls">
                                            <input value="{{old('booking_rate')}}" readonly id="booking_rate" type="text" name="booking_rate" />
                                            <input type="hidden" name="total_rates" id="total_rates">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Guest Data</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <input type="hidden" name="guest_id" id="guest_id">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.guestTitle')</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="guest_title" id="mr"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mr">Mr</label>
                                        <input type="radio" value="2" name="guest_title" id="mrs"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mrs">Mrs</label>
                                        <input type="radio" value="3" name="guest_title" id="mis"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mis">Miss</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.firstName')</label>
                                    <div class="controls">
                                        <input value="{{old('first_name')}}" id="first_name" type="text" name="first_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.lastName')</label>
                                    <div class="controls">
                                        <input value="{{old('last_name')}}" id="last_name" type="text" name="last_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.guestType')</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="guest_type" id="reg"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="reg">Regular</label>
                                        <input type="radio" value="2" name="guest_type" id="vip"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="vip">VIP</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.idType')</label>
                                    <div class="controls">
                                        <select id="id_type" name="id_type">
                                            <option value="0" disabled selected>@lang('web.choose')</option>
                                            @foreach($idType as $key => $val)
                                                <option @if(old('id_type') == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.idNumber')</label>
                                    <div class="controls">
                                        <input value="{{old('id_number')}}" id="id_number" type="text" name="id_number" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input value="{{old('email')}}" id="email" type="text" name="email" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.phone')</label>
                                    <div class="controls">
                                        <input value="{{old('homephone')}}" id="homephone" type="text" name="homephone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.handphone')</label>
                                    <div class="controls">
                                        <input value="{{old('handphone')}}" id="handphone" type="text" name="handphone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.birthplace')</label>
                                    <div class="controls">
                                        <input value="{{old('birthplace')}}" id="birthplace" type="text" name="birthplace" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.birthdate')</label>
                                    <div class="controls">
                                        <input value="{{old('birthdate')}}" id="birthdate" type="text" name="birthdate" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.gender')</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="gender" id="male"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="male">@lang('web.male')</label>
                                        <input type="radio" value="2" name="gender" id="female"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="female">@lang('web.female')</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.religion')</label>
                                    <div class="controls">
                                        <select id="religion" name="religion">
                                            <option value="0" disabled selected>@lang('web.choose')</option>
                                            @foreach($religion as $val)
                                                <option @if(old('religiom') == $val) selected="selected" @endif value="{{$val}}">{{ucwords($val)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.job')</label>
                                    <div class="controls">
                                        <input value="{{old('job')}}" id="job" type="text" name="job" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.address')</label>
                                    <div class="controls">
                                        <textarea id="address" name="address"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('module.country')</label>
                                    <div class="controls">
                                        <select id="country_id" name="country_id">
                                            <option value="0" disabled selected>@lang('web.choose')</option>
                                            @foreach($country as $key => $val)
                                                <option @if(old('country') == $val['country_id']) selected="selected" @endif value="{{$val['country_id']}}">{{$val['country_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="provinceContainer" class="control-group">
                                    <label class="control-label">@lang('module.province')</label>
                                    <div class="controls">
                                        <select id="province_id" name="province_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="@lang('web.saveForm')">
            </div>
        </form>
    </div>

    {{--MODAL--}}

    <div id="modalSelectRoom" class="modal large hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>@lang('web.availableRoom')</h3>
        </div>
        <div class="modal-body">
            <div class="legend-status" style="margin-top: 10px">
                <span class="vacant">&nbsp;</span><span class="legend-title">@lang('web.vacant')</span>
                <span class="occupied">&nbsp;</span><span class="legend-title">@lang('web.occupied')</span>
                <span class="guaranteed">&nbsp;</span><span class="legend-title">@lang('web.bookingTypeGuaranteed')</span>
                <span class="tentative">&nbsp;</span><span class="legend-title">@lang('web.bookingTypeTentative')</span>
            </div>
            <div style="clear: both;margin-top: 20px"></div>
            <table class="table table-bordered view-room">
                <tbody id="listRoom">
                <tr>
                    <td style="text-align: center" colspan="7">@lang('msg.selectCheckinCheckout')</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalFindGuest" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>@lang('web.findGuest')</h3>
        </div>
        <div class="modal-body">
            <form id="searchGuestForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">@lang('web.searchName')</label>
                        <div class="controls">
                            <input id="searchguest" name="query" type="text" />
                            <input type="submit" value="@lang('web.search')" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>@lang('web.name')</th>
                        <th>ID</th>
                        <th>@lang('web.action')</th>
                    </tr>
                </thead>
                <tbody id="listGuest">
                    @foreach($guest as $key => $val)
                        <tr class="{{($val['guest_id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                            <td>{{$val['first_name'].' '.$val['last_name']}}</td>
                            <td>{{$val['id_number']}} ({{$guestModel->getIdTypeName($val['id_type'])}})</td>
                            <td><a data-dismiss="modal" data-firstname="{{$val['first_name']}}" data-lastname="{{$val['last_name']}}" data-guesttype="{{$val['type']}}"
                                   data-idtype="{{$val['id_type']}}" data-idnumber="{{$val['id_number']}}" data-id="{{$val['guest_id']}}" data-email="{{$val['email']}}" data-birthdate="{{$val['birthdate']}}"
                                   data-religion="{{$val['religion']}}" data-gender="{{$val['gender']}}" data-job="{{$val['job']}}" data-birthplace="{{$val['birthplace']}}"
                                   data-address="{{$val['address']}}" data-countryid="{{$val['country_id']}}" data-provinceid="{{$val['province_id']}}"
                                   data-zipcode="{{$val['zipcode']}}" data-homephone="{{$val['homephone']}}" data-handphone="{{$val['handphone']}}" data-guesttitle="{{$val['title']}}"
                                   id="guest-{{$val['guest_id']}}" class="btn btn-success chooseGuest">@lang('web.choose')</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
