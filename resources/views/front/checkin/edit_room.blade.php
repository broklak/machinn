<form id="form-booking" method="post" action="{{route('checkin.room-edit', ['id' => $header->booking_id])}}">
    {{csrf_field()}}
    <div id="error_messages" style="margin-top: 20px">

    </div>
    <table class="table table-bordered table-detail">
        <tr>
            <td class="title">Room Plan</td>
            <td>
                <select id="room_plan_id" name="room_plan_id">
                    <option value="0" disabled selected>Choose Room Plan</option>
                    @foreach($plan as $key => $val)
                        <option @if($header->room_plan_id == $val['room_plan_id']) selected="selected" @endif value="{{$val['room_plan_id']}}">{{$val['room_plan_name']}}</option>
                    @endforeach
                </select>
            </td>
            <td class="title">Source</td>
            <td>
                <select id="partner_id" name="partner_id">
                    <option value="0" disabled selected>Choose Source</option>
                    @foreach($source as $key => $val)
                        <option @if($header->partner_id == $val['partner_id']) selected="selected" @endif value="{{$val['partner_id']}}">{{$val['partner_name']}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td class="title">Check In Date</td>
            <td>
                <input readonly value="{{$header->checkin_date}}" id="checkin" type="text" name="checkin_date" />
            </td>
            <td class="title">Check Out Date</td>
            <td>
                <input value="{{$header->checkout_date}}" id="checkout" type="text" name="checkout_date" />
            </td>
        </tr>
        <tr>
            <td class="title">Adult Numbers</td>
            <td>
                <input value="{{$header->adult_num}}" max="2" id="adult" type="number" name="adult_num" />
            </td>
            <td class="title">Child Num</td>
            <td>
                <input value="{{$header->child_num}}" max="2" id="child" type="number" name="child_num" />
            </td>
        </tr>
        <tr>
            <td class="title">Banquet</td>
            <td>
                <input type="radio" @if($header->is_banquet == 0) checked @endif value="0" name="is_banquet" id="no_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no_ban">No</label>
                <input type="radio" @if($header->is_banquet == 1) checked @endif value="1" name="is_banquet" id="yes_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes_ban">Yes</label>
            </td>
            <td class="title">Notes</td>
            <td>
                <textarea name="notes">{{$header->notes}}</textarea>
            </td>
        </tr>
    </table>
    <a style="margin-bottom: 15px" href="#modalSelectRoom" data-toggle="modal" class="btn btn-info">Add Room</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Rate Weekdays</th>
            <th>Rate Weekdays</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="list-room">
        @foreach($header->room_data as $key => $val)
            <tr>
                <td>{{$val['code']}}</td>
                <td>{{\App\RoomNumber::getTypeName($val['type'])}}</td>
                <td>{{\App\Helpers\GlobalHelper::moneyFormat($val['rateWeekdays'])}}</td>
                <td>{{\App\Helpers\GlobalHelper::moneyFormat($val['rateWeekends'])}}</td>
                <td><a class="btn btn-danger removeRoom" data-id="{{$key}}" data-code="{{$val['code']}}" data-type="{{$val['type']}}"
                       data-weekendrate="{{$val['rateWeekends']}}" data-weekdayrate="{{$val['rateWeekdays']}}">
                        <i class="icon-remove"></i> Remove Room
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <input style="display: block;width: 100%" type="submit" class="btn btn-primary" value="SAVE">
    <input type="hidden" value="{{$header->room_list}}" name="room_number" id="room_number">
    <input type="hidden" name="total_rates" value="0" id="total_rates">
</form>
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
            <table class="table table-bordered view-room">
                <tbody id="listRoom">
                <tr>
                    <td style="text-align: center" colspan="7">Please Select Check In and Check Out Date</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
