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
            </tr>
            </thead>
            <tbody>
            @foreach($payment as $key => $val)
                <tr>
                    <td>{{date('j F Y', strtotime($val['created_at']))}}</td>
                    <td>{{\App\BookingPayment::setDescription($val->type, $val->extracharge_id)}}</td>
                    <td>{!! \App\BookingPayment::setPaymentMethodDescription($val->payment_method, $val->card_name, $val->card_type, $val->card_number, $val->bank_transfer_recipient)!!}</td>
                    <td class="right"><strong>{{\App\Helpers\GlobalHelper::moneyFormat($val->total_payment)}}</strong></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table class="table table-bordered table-invoice-full hide">
            <tbody>
            <tr>
                <td class="msg-invoice" width="85%"><h4>Payment method: </h4>
                    <a href="#" class="tip-bottom" title="Wire Transfer">Wire transfer</a> |  <a href="#" class="tip-bottom" title="Bank account">Bank account #</a> |  <a href="#" class="tip-bottom" title="SWIFT code">SWIFT code </a>|  <a href="#" class="tip-bottom" title="IBAN Billing address">IBAN Billing address </a></td>
                <td class="right"><strong>Subtotal</strong> <br>
                    <strong>Tax (5%)</strong> <br>
                    <strong>Discount</strong></td>
                <td class="right"><strong>$7,000 <br>
                        $600 <br>
                        $50</strong></td>
            </tr>
            </tbody>
        </table>
        <div class="pull-right hide">
            <h4><span>Amount Due:</span> $7,650.00</h4>
            <br>
            <a class="btn btn-primary btn-large pull-right" href="">Pay Invoice</a> </div>
    </div>
</div>