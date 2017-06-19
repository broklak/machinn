<table class="table table-bordered">
    <thead>
    <tr>
        <th>@lang('web.checkinDate')</th>
        <th>@lang('web.checkoutDate')</th>
        <th>@lang('web.room')</th>
        <th>@lang('module.roomPlan')</th>
        <th>Total @lang('web.bill')</th>
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
