<div class="widget-box">
    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
        <h5>@lang('web.edit') @lang('module.transaction')</h5>
    </div>
    <div class="widget-content nopadding">
        <div id="form-wizard-1" class="step">
            <div class="control-group">
                <label class="control-label">@lang('web.billNumber')</label>
                <div class="controls">
                    <input id="bill_number" value="{{$row->bill_number}}" readonly type="text" name="bill_number" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">@lang('web.billNumber')</label>
                <div class="controls">
                    <input type="radio" @if($row->delivery_type == 1) checked @endif value="1" name="delivery_type" id="dine"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="dine">@lang('web.deliveryTypeDine')</label>
                    <input type="radio" @if($row->delivery_type == 2) checked @endif value="2" name="delivery_type" id="rose"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="rose">@lang('web.deliveryTypeRoom')</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">@lang('web.date')</label>
                <div class="controls">
                    <input @if($row->status != 1) readonly @endif id="date" value="{{date('Y-m-d')}}" type="text" name="date" />
                </div>
            </div>
            <div id="guest-type-cont" class="control-group @if($row->delivery_type == 2) hide @endif">
                <label class="control-label">@lang('web.guest')</label>
                <div class="controls">
                    <input type="radio" @if($row->guest_id == 0) checked @endif value="0" name="is_guest" id="no"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no">@lang('web.no') @lang('web.guest')</label>
                    <input type="radio" @if($row->guest_id != 0) checked @endif value="1" name="is_guest" id="yes"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes">@lang('web.guest')</label>
                </div>
            </div>
            <div id="guest-cont" class="control-group @if($row->guest_id == 0) hide @endif">
                <label class="control-label">@lang('web.name')</label>
                <div class="controls">
                    <input type="text" value="{{($row->guest_id == 0) ? '' : \App\Guest::getFullName($row->guest_id)}}" readonly id="guest_name" name="guest_name">
                    <input type="hidden" id="guest_id" value="{{$row->guest_id}}" name="guest_id">
                    <a href="@if($row->status == 1) #modalFindGuest @endif" data-toggle="modal" class="btn btn-inverse">@lang('web.findGuest')</a>
                </div>
            </div>
            <div id="room-cont" class="control-group @if($row->room_id == null) hide @endif">
                <label class="control-label">@lang('web.room')</label>
                <div class="controls">
                    <input id="room_code" value="{{($row->room_id == null || $row->room_id == 0) ? '' : \App\RoomNumber::getCode($row->room_id)}}" readonly type="text" name="room_code" />
                    <input id="room_id" value="{{$row->room_id}}" type="hidden" name="room_id" />
                    <input id="booking_id" value="{{$row->booking_id}}" type="hidden" name="booking_id" />
                </div>
            </div>
            <div id="guest-num-cont" class="control-group @if($row->delivery_type == 2) hide @endif">
                <label class="control-label">@lang('web.numberGuest')</label>
                <div class="controls">
                    <input @if($row->status != 1) readonly @endif id="guest_num" value="{{$row->guest_num}}" type="text" name="guest_num" />
                </div>
            </div>
            <div id="table-cont" class="control-group @if($row->delivery_type == 2) hide @endif">
                <label class="control-label">@lang('web.tableNumber')</label>
                <div class="controls">
                    <input @if($row->status != 1) readonly @endif id="table_id" value="{{\App\PosTable::getName($row->table_id)}}" type="text" name="table_id" list="table-list" />
                    <datalist aria-multiselectable="true" id="table-list">
                        @foreach($table as $key => $val)
                            <option>{{$val->name}}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div id="bill-cont" class="control-group @if($row->guest_id == 0) hide @endif">
                <label class="control-label">@lang('web.billed')</label>
                <div class="controls">
                    <input type="radio" @if($row->bill_type == 1) checked @endif value="1" name="bill_type" id="dir"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="dir">@lang('web.directPayment')</label>
                    <input type="radio" @if($row->bill_type == 2) checked @endif value="2" name="bill_type" id="room"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="room">@lang('web.billedRoom')</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">@lang('web.waiters')</label>
                <div class="controls">
                    <select name="waiters">
                        <option value="0">@lang('web.choose')</option>
                        @foreach($waiters as $key => $val)
                            <option @if($row->waiters == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
