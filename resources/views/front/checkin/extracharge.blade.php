    <div>
        <a data-toggle="modal" href="#modalFindItem" class="btn btn-primary" style="margin-bottom: 15px">@lang('web.addButton') @lang('web.extracharge')</a>
    </div>
 <form method="post" action="{{route('checkin.extracharge', ['id' => $header->booking_id])}}">
     {{csrf_field()}}
     <input type="hidden" name="guest_id" value="{{$guest->guest_id}}">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>{{strtoupper(__('web.date'))}}</th>
            <th>{{strtoupper(__('web.room'))}}</th>
            <th>{{strtoupper(__('web.extracharge'))}}</th>
            <th>{{strtoupper(__('web.price'))}}</th>
            <th>{{strtoupper(__('web.qty'))}}</th>
            <th>DISCOUNT</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody id="list-data">
        @php $grand = 0 @endphp
        @foreach($extra as $key => $value)
            <tr id="item-{{$value->extracharge_id}}">
                <td>{{date('j F Y', strtotime($value->created_at))}}</td>
                <td>
                    @php $room_list = explode(',', $header->room_list); @endphp
                    <select style="width: 80px" name="room_id[{{$value->extracharge_id}}]">
                        @foreach($room_list as $key_detail => $val_detail)
                            <option @if($val_detail == $value->booking_room_id) selected @endif value="{{$val_detail}}">{{\App\RoomNumber::getCode($val_detail)}}</option>
                        @endforeach
                    </select>
                </td>
                <td>{{\App\Extracharge::getName($value->extracharge_id)}}</td>
                <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->price)}}</td>
                <td>
                    <input type="number" name="qty[{{$value->extracharge_id}}]" onchange="changeQty($(this))" onkeyup="changeQty($(this))"
                           id="qty-{{$value->extracharge_id}}" data-id="{{$value->extracharge_id}}" class="qtyItem" value="{{$value->qty}}" style="width: 30px" />
                    <input type="hidden" name="price[{{$value->extracharge_id}}]" id="price-{{$value->extracharge_id}}" value="{{$value->price}}" />
                </td>
                <td>
                    <input type="number" id="discount-{{$value->extracharge_id}}" name="discount[{{$value->extracharge_id}}]" onchange="changeDiscount($(this))"
                           onkeyup="changeDiscount($(this))" data-id="{{$value->extracharge_id}}" value="{{$value->discount}}"
                           style="width: 80px" />
                    <input type="hidden" name="subtotal[{{$value->extracharge_id}}]" id="subtotal-{{$value->extracharge_id}}" value="{{$value->total_payment}}" />
                    <input type="hidden" id="discount-{{$value->extracharge_id}}" value="{{$value->discount}}" />
                </td>
                <td>
                    <span id="total-{{$value->extracharge_id}}">{{\App\Helpers\GlobalHelper::moneyFormat($value->total_payment)}} &nbsp;</span>
                    <a id="deleteCart-{{$value->extracharge_id}}" onclick="deleteCart($(this))" data-id="{{$value->extracharge_id}}" data-price="{{$value->total_payment}}">
                        <i class="icon-2x icon-remove"></i>
                    </a>
                </td>
            </tr>
            @php $grand = $grand + $value->total_payment @endphp
        @endforeach
        <tr>
            <td colspan="8" style="text-align: right;font-weight: bold;font-size: 18px">GRAND TOTAL : <span id="grand_total_text">
                                                                {{\App\Helpers\GlobalHelper::moneyFormat($grand)}}</span>
                <input type="hidden" name="grand_total" value="{{$grand}}" id="grand_total">
            </td>
        </tr>
        <tr>
            <td colspan="8"><input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="{{strtoupper(__('web.saveChange'))}}"></td>
        </tr>
        </tbody>
    </table>
</form>

    <div id="modalFindItem" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Find Item</h3>
        </div>
        <div class="modal-body">
            <form id="searchItemForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-item" class="step">
                    <div class="control-group">
                        <label class="control-label">@lang('web.search') {{strtoupper(__('web.itemName'))}}</label>
                        <div class="controls">
                            <input id="searchitem" name="query" type="text" />
                            <input type="submit" value="@lang('web.search')" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('web.name')</th>
                    <th>@lang('web.price')</th>
                    <th>@lang('web.action')</th>
                </tr>
                </thead>
                <tbody id="listItem">
                @foreach($charge as $key => $val)
                    <tr class="{{($val['guest_id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                        <td>{{$val->extracharge_name}}</td>
                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->extracharge_price)}}</td>
                        <td>
                            <a data-dismiss="modal" data-id="{{$val->extracharge_id}}" data-price="{{$val->extracharge_price}}" data-name="{{$val->extracharge_name}}"
                              class="btn btn-success chooseItem">@lang('web.choose')</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
