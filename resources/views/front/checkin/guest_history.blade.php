<table class="table table-bordered">
    <thead>
    <tr>
        <th>Check In Date</th>
        <th>Check Out Date</th>
        <th>Room List</th>
        <th>Rate Plan</th>
        <th>Total Billed</th>
    </tr>
    </thead>
    <tbody>
    @foreach($history as $key => $value)
        <tr>
            <td>{{date('j F Y', strtotime($value->checkin_date))}}</td>
            <td>{{date('j F Y', strtotime($value->checkout_date))}}</td>
            <td>{{\App\RoomNumber::getRoomCodeList($value->room_list)}}</td>
            <td>{{$value->room_plan_name}}</td>
            <td>{{\App\Helpers\GlobalHelper::moneyFormat($value->grand_total)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>