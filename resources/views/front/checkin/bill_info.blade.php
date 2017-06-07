@if(count($deposit) == 0)
<a href="#modalDeposit" data-toggle="modal" class="btn btn-primary">Add Deposit</a>
@endif
<div class="row-fluid">
    <div class="span6">
        <table class="">
            <tbody>
            <tr>
                <td><h4>Billed to</h4></td>
            </tr>
            <tr>
                <td>{{\App\Guest::getTitleName($guest->title)}} {{$guest->first_name}} {{$guest->last_name}}</td>
            </tr>
            <tr>
                <td>ID: {{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
            </tr>
            <tr>
                <td >Mobile Phone : {{$guest->handphone}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="span6">
        <table class="table table-bordered table-invoice">
            <tbody>
            <tr>
            <tr>
                <td class="width30">Check In Date</td>
                <td class="width70"><strong>{{date('j F Y', strtotime($header->checkin_date))}}</strong></td>
            </tr>
            <tr>
                <td>Check Out date</td>
                <td><strong>{{date('j F Y', strtotime($header->checkout_date))}}</strong></td>
            </tr>
            <tr>
                <td>Room Number</td>
                <td><strong>{{\App\RoomNumber::getRoomCodeList($header->room_list)}}</strong></td>
            </tr>
            </tbody>

        </table>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered table-invoice-full">
            <thead>
            <tr>
                <th class="head0">Date</th>
                <th class="head1">Description</th>
                <th class="head0">Payment Method</th>
                <th class="head0 right">Amount</th>
                <th class="head0">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payment as $key => $val)
                <tr>
                    <td>{{date('j F Y', strtotime($val['created_at']))}}</td>
                    <td>{{\App\BookingPayment::setDescription($val->type, $val->extracharge_id, $val->deposit)}}</td>
                    <td>{!! \App\BookingPayment::setPaymentMethodDescription($val->payment_method, $val->card_name, $val->card_type, $val->card_number, $val->bank_transfer_recipient)!!}</td>
                    <td class="right"><strong>{{\App\Helpers\GlobalHelper::moneyFormat($val->total_payment)}}</strong></td>
                    <td></td>
                </tr>
            @endforeach
            @if(!empty($deposit))
                <tr>
                    <td>{{date('j F Y', strtotime($deposit->created_at))}}</td>
                    <td>Check In Deposit</td>
                    <td>Cash to Front Office</td>
                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($deposit->amount)}}</td>
                    <td>
                        <a href="#" onClick="window.open('{{route('checkin.print-deposit', ['id' => $header->booking_id])}}','pagename','resizable,height=800,width=750');
                                return false;" class="btn btn-success">Print Receipt</a><noscript>
                            You need Javascript to use the previous link or use <a href="yourpage.htm" target="_blank">New Page
                            </a>
                        </noscript>
                        <a onclick="return confirm('You will void deposit of this booking, continue?')" class="btn btn-danger"
                           href="{{route('checkin.void-deposit', ['bookingId' => $header->booking_id])}}">Void Deposit</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

<div id="modalDeposit" class="modal hide">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h3>Deposit Booking #{{$header->booking_code}}</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" method="post" action="{{route("$route_name.deposit", ['booking_id' => $header->booking_id])}}">
            {{csrf_field()}}
            <div id="form-search-guest" class="step">
                <div class="control-group">
                    <label class="control-label">Deposit Amount</label>
                    <div class="controls">
                        <input onkeyup="formatMoney($(this))" name="amount" type="text" required />
                    </div>
                </div>
                <div class="form-actions text-center">
                    <button type="submit" class="btn btn-success">Add Deposit</button>
                </div>
            </div>
        </form>
    </div>
</div>