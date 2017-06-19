<form id="form-booking" method="post" action="{{route('checkin.room-edit', ['id' => $header->booking_id])}}">
    {{csrf_field()}}
    <div id="error_messages" style="margin-top: 20px">

    </div>
    <table class="table table-bordered table-detail">
        <tr>
            <td class="title">@lang('web.roomPlan')</td>
            <td>
                <select id="room_plan_id" name="room_plan_id">
                    <option value="0" disabled selected>@lang('web.choose')</option>
                    @foreach($plan as $key => $val)
                        <option @if($header->room_plan_id == $val['room_plan_id']) selected="selected" @endif value="{{$val['room_plan_id']}}">{{$val['room_plan_name']}}</option>
                    @endforeach
                </select>
            </td>
            <td class="title">@lang('web.source')</td>
            <td>
                <select id="partner_id" name="partner_id">
                    <option value="0" disabled selected>@lang('web.choose')</option>
                    @foreach($source as $key => $val)
                        <option @if($header->partner_id == $val['partner_id']) selected="selected" @endif value="{{$val['partner_id']}}">{{$val['partner_name']}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td class="title">@lang('web.checkinDate')</td>
            <td>
                <input readonly value="{{$header->checkin_date}}" id="checkin" type="text" name="checkin_date" />
            </td>
            <td class="title">@lang('web.checkoutDate')</td>
            <td>
                <input value="{{$header->checkout_date}}" id="checkout" type="text" name="checkout_date" />
            </td>
        </tr>
        <tr>
            <td class="title">@lang('web.adultNumbers')</td>
            <td>
                <input value="{{$header->adult_num}}" max="2" id="adult" type="number" name="adult_num" />
            </td>
            <td class="title">@lang('web.childNumbers')</td>
            <td>
                <input value="{{$header->child_num}}" max="2" id="child" type="number" name="child_num" />
            </td>
        </tr>
        <tr>
            <td class="title">@lang('module.banquet')</td>
            <td>
                <input type="radio" @if($header->is_banquet == 0) checked @endif value="0" name="is_banquet" id="no_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no_ban">@lang('web.no')</label>
                <input type="radio" @if($header->is_banquet == 1) checked @endif value="1" name="is_banquet" id="yes_ban"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes_ban">@lang('web.yes')</label>
            </td>
            <td class="title">@lang('web.notes')</td>
            <td>
                <textarea name="notes">{{$header->notes}}</textarea>
            </td>
        </tr>
    </table>
    <a style="margin-bottom: 15px" href="#modalSelectRoom" data-toggle="modal" class="btn btn-info">@lang('web.addButton') @lang('web.room')</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>@lang('module.roomNumber')</th>
            <th>@lang('module.roomType')</th>
            <th>@lang('web.rate') Weekdays</th>
            <th>@lang('web.rate') Weekends</th>
            <th>@lang('web.action')</th>
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
                        <i class="icon-remove"></i> @lang('web.delete') @lang('web.room')
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <input style="display: block;width: 100%" type="submit" class="btn btn-primary" value="@lang('web.saveForm')">
    <input type="hidden" value="{{$header->room_list}}" name="room_number" id="room_number">
    <input type="hidden" name="total_rates" value="0" id="total_rates">
</form>
    {{--MODAL--}}

    <div id="modalSelectRoom" class="modal large hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>@lang('web.availableRoom')</h3>
        </div>
        <div class="modal-body">
            <form id="searchRoomForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">Filter @lang('web.room')</label>
                        <div class="controls">
                            <select id="room_type_filter" name="room_type">
                                <option value="0" selected>@lang('web.allRoomType')</option>
                                @foreach($room_type as $key => $val)
                                    <option value="{{$val['room_type_id']}}">{{$val['room_type_name']}}</option>
                                @endforeach
                            </select>
                            <select id="floor_filter" name="floor">
                                <option value="0" selected>@lang('web.allFloor')</option>
                                @foreach($floor as $key => $val)
                                    <option value="{{$val['property_floor_id']}}">{{$val['property_floor_name']}}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="@lang('web.search')" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered view-room">
                <tbody id="listRoom">
                <tr>
                    <td style="text-align: center" colspan="7">@lang('msg.selectCheckinCheckout')</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
