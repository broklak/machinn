<form action="{{route('checkin.rate', ['id' => $header->booking_id])}}" method="post">
    {{csrf_field()}}
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>DATE</th>
            <th>ROOM NUMBER</th>
            <th>ROOM RATE PRICE</th>
            <th>ROOM PLAN PRICE</th>
            <th>DISCOUNT</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($detail as $key => $value)
            <tr>
                <td>{{date('j F Y', strtotime($value->room_transaction_date))}}</td>
                <td>{{\App\RoomNumber::getCode($value->room_number_id)}}</td>
                <td><input id="room_rate_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="room_rate[{{$value->booking_room_id}}]" onkeyup="changeRate($(this))" onchange="changeRate($(this))" type="text" value="{{$value->room_rate}}" /></td>
                <td><input id="plan_rate_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="plan_rate[{{$value->booking_room_id}}]" onkeyup="changePlan($(this))" onchange="changePlan($(this))" type="text" value="{{$value->room_plan_rate}}" /></td>
                <td><input id="discount_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="discount[{{$value->booking_room_id}}]" onkeyup="changeDiscountRate($(this))" onchange="changeDiscountRate($(this))" type="text" value="{{$value->discount}}" /></td>
                <td id="sub_text_{{$value->booking_room_id}}">{{\App\Helpers\GlobalHelper::moneyFormat($value->subtotal)}}</td>
                <input type="hidden" name="subtotal[{{$value->booking_room_id}}]" id="subtotal_{{$value->booking_room_id}}" value="{{$value->subtotal}}" />
            </tr>
        @endforeach
            <tr>
                <td colspan="6" style="text-align: right;font-weight: bold;font-size: 16px">GRAND TOTAL :
                    <span id="grand_rate_text">{{\App\Helpers\GlobalHelper::moneyFormat($header->grand_total)}}</span>
                    <input type="hidden" id="grand_rate" name="grand_total" value="{{$header->grand_total}}">
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: right;font-weight: bold;font-size: 16px"><input type="submit" value="SAVE CHANGE" class="btn btn-success"></td>
            </tr>
        </tbody>
    </table>
</form>