@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Create {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
            {{csrf_field()}}
            <div class="row-fluid">
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Create New {{$master_module}}</h5>
                        </div>
                        <div class="widget-content nopadding">
                                <div id="form-wizard-1" class="step">
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Type</label>
                                        <div class="controls">
                                            <input @if(old('type') == 1) checked @endif type="radio" value="1" name="type" id="gua"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="gua">Guaranteed</label>
                                            <input @if(old('type') == 2) checked @endif type="radio" value="2" name="type" id="ten"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="ten">Tentative</label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Room Plan</label>
                                        <div class="controls">
                                            <select name="room_plan_id">
                                                <option disabled selected>Choose Room Plan</option>
                                                @foreach($plan as $key => $val)
                                                    <option @if(old('room_plan_id') == $val['room_plan_id']) selected="selected" @endif value="{{$val['room_plan_id']}}">{{$val['room_plan_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Source</label>
                                        <div class="controls">
                                            <select name="partner_id">
                                                <option disabled selected>Choose Source</option>
                                                @foreach($source as $key => $val)
                                                    <option @if(old('partner_id') == $val['partner_id']) selected="selected" @endif value="{{$val['partner_id']}}">{{$val['partner_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Check In Date</label>
                                        <div class="controls">
                                            <input value="{{old('checkin_date')}}" id="checkin" type="text" name="checkin_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Check Out Date</label>
                                        <div class="controls">
                                            <input value="{{old('checkout_date')}}" id="checkout" type="text" name="checkout_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Adult Numbers</label>
                                        <div class="controls">
                                            <input value="{{old('adult_num')}}" id="adult" type="number" name="adult_num" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Child Numbers</label>
                                        <div class="controls">
                                            <input value="{{old('child_num')}}" id="child" type="number" name="child_num" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Banquet</label>
                                        <div class="controls">
                                            <input type="radio" @if(old('is_banquet') == 0) checked @endif value="0" name="is_banquet" id="no_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no_ban">No</label>
                                            <input type="radio" @if(old('is_banquet') == 1) checked @endif value="1" name="is_banquet" id="yes_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes_ban">Yes</label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Room Number</label>
                                        <div class="controls">
                                            <div id="selectedRoomContainer" style="margin-bottom: 15px"></div>
                                            <a href="#modalSelectRoom" data-toggle="modal" class="btn btn-info">Select Room</a>
                                            <input type="hidden" name="room_number" id="room_number">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Notes</label>
                                        <div class="controls">
                                            <textarea name="notes"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Guest</label>
                                        <div class="controls">
                                            <a href="#modalFindGuest" data-toggle="modal" class="btn btn-inverse">Find Guest</a>
                                            <a href="#" id="createGuestButton" data-toggle="modal" class="btn btn-primary">Add New Guest</a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Total Room Rates</label>
                                        <div class="controls">
                                            <input value="{{old('booking_rate')}}" readonly id="booking_rate" type="text" name="booking_rate" />
                                            <input type="hidden" name="total_rates" id="total_rates">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div id="dp-container" class="widget-box hide">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Down Payment</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <input type="hidden" id="need_dp" />
                                <div class="control-group">
                                    <label class="control-label">Payment Method</label>
                                    <div class="controls">
                                        <select id="payment_method" name="payment_method">
                                            <option disabled selected>Choose Payment Method</option>
                                            @foreach($payment_method as $key => $val)
                                                <option @if(old('payment_method') == $val) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Down Payment Amount</label>
                                    <div class="controls">
                                        <input value="{{old('down_payment_amount')}}" id="down_payment_amount" type="number" name="down_payment_amount" />
                                    </div>
                                </div>
                                <div id="cc-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">Settlement</label>
                                        <div class="controls">
                                            <select name="settlement">
                                                <option value="0" selected>Choose Settlement</option>
                                                @foreach($settlement as $key => $val)
                                                    <option @if(old('settlement') == $val['settlement_id']) selected="selected" @endif value="{{$val['settlement_id']}}">{{$val['settlement_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Type</label>
                                        <div class="controls">
                                            <input type="radio" value="1" name="card_type" id="cre"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="cre">Credit Card</label>
                                            <input type="radio" value="2" name="card_type" id="deb"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="deb">Debit Card</label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Number</label>
                                        <div class="controls">
                                            <input value="{{old('card_number')}}" id="card_number" type="text" name="card_number" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Holder Name</label>
                                        <div class="controls">
                                            <input value="{{old('card_holder')}}" id="card_holder" type="text" name="card_holder" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Card Expired Date</label>
                                        <div class="controls">
                                            <input value="{{old('card_expired_date')}}" id="card_expired_date" type="text" data-date-format="yyyy-mm-dd" name="card_expired_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Credit Card Type</label>
                                        <div class="controls">
                                            <select name="cc_type">
                                                <option value="0" selected>Choose CC Type</option>
                                                @foreach($cc_type as $key => $val)
                                                    <option @if(old('cc_type') == $val['cc_type_id']) selected="selected" @endif value="{{$val['cc_type_id']}}">{{$val['cc_type_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Bank</label>
                                        <div class="controls">
                                            <select name="bank">
                                                <option value="0" selected>Choose Bank</option>
                                                @foreach($bank as $key => $val)
                                                    <option @if(old('bank') == $val['bank_id']) selected="selected" @endif value="{{$val['bank_id']}}">{{$val['bank_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="bt-container" class="hide">
                                    <div class="control-group">
                                        <label class="control-label">Account Recipient</label>
                                        <div class="controls">
                                            <select name="cash_account_id">
                                                <option value="0" selected>Choose Recipient</option>
                                                @foreach($cash_account as $key => $val)
                                                    <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                    <label class="control-label">Guest Title</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="guest_title" id="mr"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mr">Mr</label>
                                        <input type="radio" value="2" name="guest_title" id="mrs"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mrs">Mrs</label>
                                        <input type="radio" value="3" name="guest_title" id="mis"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mis">Miss</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">First Name</label>
                                    <div class="controls">
                                        <input value="{{old('first_name')}}" id="first_name" type="text" name="first_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Last Name</label>
                                    <div class="controls">
                                        <input value="{{old('last_name')}}" id="last_name" type="text" name="last_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Guest Type</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="guest_type" id="reg"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="reg">Regular</label>
                                        <input type="radio" value="2" name="guest_type" id="vip"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="vip">VIP</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">ID Type</label>
                                    <div class="controls">
                                        <select id="id_type" name="id_type">
                                            <option disabled selected>Choose ID Type</option>
                                            @foreach($idType as $key => $val)
                                                <option @if(old('id_type') == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">ID Number</label>
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
                                    <label class="control-label">Phone Number</label>
                                    <div class="controls">
                                        <input value="{{old('homephone')}}" id="homephone" type="text" name="homephone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Handphone Number</label>
                                    <div class="controls">
                                        <input value="{{old('handphone')}}" id="handphone" type="text" name="handphone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Birthplace</label>
                                    <div class="controls">
                                        <input value="{{old('birthplace')}}" id="birthplace" type="text" name="birthplace" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Birthdate</label>
                                    <div class="controls">
                                        <input value="{{old('birthdate')}}" id="birthdate" type="text" name="birthdate" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="gender" id="male"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="male">Male</label>
                                        <input type="radio" value="2" name="gender" id="female"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="female">Female</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Religion</label>
                                    <div class="controls">
                                        <select id="religion" name="religion">
                                            <option disabled selected>Select Religion</option>
                                            @foreach($religion as $val)
                                                <option @if(old('religiom') == $val) selected="selected" @endif value="{{$val}}">{{ucwords($val)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Job</label>
                                    <div class="controls">
                                        <input value="{{old('job')}}" id="job" type="text" name="job" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Address</label>
                                    <div class="controls">
                                        <textarea id="address" name="address"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Country</label>
                                    <div class="controls">
                                        <select id="country_id" name="country_id">
                                            <option disabled selected>Choose Country</option>
                                            @foreach($country as $key => $val)
                                                <option @if(old('country') == $val['country_id']) selected="selected" @endif value="{{$val['country_id']}}">{{$val['country_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="provinceContainer" class="control-group">
                                    <label class="control-label">Province</label>
                                    <div class="controls">
                                        <select id="province_id" name="province_id">
                                            <option disabled selected>Choose Province</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE">
            </div>
        </form>
    </div>

    {{--MODAL--}}

    <div id="modalSelectRoom" class="modal large hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Available Rooms</h3>
        </div>
        <div class="modal-body">
            <form id="searchRoomForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">Filter Room</label>
                        <div class="controls">
                            <select id="room_type_filter" name="room_type">
                                <option value="0" selected>All Room Type</option>
                                @foreach($room_type as $key => $val)
                                    <option value="{{$val['room_type_id']}}">{{$val['room_type_name']}}</option>
                                @endforeach
                            </select>
                            <select id="floor_filter" name="floor">
                                <option value="0" selected>All Floor</option>
                                @foreach($floor as $key => $val)
                                    <option value="{{$val['property_floor_id']}}">{{$val['property_floor_name']}}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Floor</th>
                        <th>Room Rate Weekdays</th>
                        <th>Room Rate Weekends</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="listRoom">
                    <tr>
                        <td style="text-align: center" colspan="7">Please Select Check In and Check Out Date</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalFindGuest" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Find Guest</h3>
        </div>
        <div class="modal-body">
            <form id="searchGuestForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">Filter Guest By Name or ID</label>
                        <div class="controls">
                            <input id="searchguest" name="query" type="text" />
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Action</th>
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
                                   id="guest-{{$val['guest_id']}}" class="btn btn-success chooseGuest">Choose</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection