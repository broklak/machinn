<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Guest Bill</title>

    <style>
        .invoice-box{
            max-width:800px;
            margin:auto;
            padding:0 20px;
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#000;
        }

        .invoice-box table{
            width:100%;
            line-height:inherit;
            text-align:left;
        }

        .invoice-box table td{
            padding:5px;
            vertical-align:top;
        }

        .invoice-box table tr.information table td:nth-child(2){
            text-align:right;
        }

        .invoice-box table tr.top table td{
            padding-bottom:10px;
        }

        .invoice-box table tr.top table td.title{
            color:#333;
            text-align: center;
        }

        .invoice-box table tr.information table td{
            padding-bottom:0px;
            font-size: 14px;
        }

        .invoice-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
            font-size: 12px;
        }

        .invoice-box table tr.head-bill td{
            text-align: left;
            border: 1px solid #000;
            font-size: 12px;
        }

        .invoice-box table tr.details td{
            padding-bottom:20px;
        }

        .invoice-box table tr.item td:first-child{
            border-left: 1px solid #eee;;
        }
        .invoice-box table tr.item td{
            border-bottom:1px solid #eee;
            border-right:1px solid #eee;
            font-size: 12px;
        }

        .invoice-box table tr.item.last td{
            border-bottom:none;
        }

        .invoice-box table tr.total td:nth-child(2){
            border-top:2px solid #eee;
            font-weight:bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td{
                width:100%;
                display:block;
                text-align:center;
            }

            .invoice-box table tr.information table td{
                width:100%;
                display:block;
                text-align:center;
            }
        }
        @media print {
            #buttonprint {
                display: none;
            }
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="4">
                <table>
                    <tr>
                        <td colspan="2" class="title">
                            <img src="{{(session('logo') == null) ? asset('img/matrix/no_image.png') : asset('storage/img/matrix/'.session('logo')) }}" style="width:100%; max-width:300px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="4">
                <table>
                    <tr>
                        <td>
                            <span style="font-size: 20px;font-weight: bold">{{$hotel_name}}</span><br>
                            {{$hotel_address}}
                        </td>

                        <td>
                            Phone : {{$hotel_phone}}<br>
                            Fax : {{$hotel_fax}}<br>
                            Email : {{$hotel_email}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center"><h2 style="font-size: 16px;margin: 20px 0 0 0">GUEST BILL INFORMATION</h2></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table>
                    <tr class="head-bill">
                        <td style="border-bottom: none;border-right: none;font-weight: bold">Booking Code</td>
                        <td style="border-bottom: none;border-right: none">{{$header->booking_code}}</td>
                        <td style="border-bottom: none;border-right: none;font-weight: bold">Bill Number</td>
                        <td style="border-bottom: none">{{$bill_number}}</td>
                    </tr>
                    <tr class="head-bill">
                        <td style="border-bottom: none;border-right: none;font-weight: bold">Check In Date</td>
                        <td style="border-bottom: none;border-right: none">{{date('j F Y', strtotime($header->checkin_date))}}</td>
                        <td style="border-bottom: none;border-right: none;font-weight: bold">Checkout Date</td>
                        <td style="border-bottom: none">{{date('j F Y', strtotime($header->checkout_date))}}</td>
                    </tr>
                    <tr class="head-bill">
                        <td style="border-right: none;font-weight: bold">Room Number</td>
                        <td style="border-right: none">{{\App\RoomNumber::getRoomCodeList($header->room_list)}}</td>
                        <td style="border-right: none;font-weight: bold">Billed To</td>
                        <td>{{$name}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="line-height: 5px">
            <td>&nbsp;</td>
        </tr>
        <tr class="heading">
            <td style="text-align: center;width: 50%">DESCRIPTION</td>
            <td style="text-align: center;width: 20%">DEBIT</td>
            <td style="text-align: center;width: 20%">KREDIT</td>
        </tr>
        <tr class="item">
            <td>Room</td>
            <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_room)}}</td>
            <td style="text-align: right">0</td>
        </tr>
        @if($total_extra != 0)
        <tr class="item">
            <td>Extracharge</td>
            <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_extra)}}</td>
            <td style="text-align: right">0</td>
        </tr>
        @endif
        @if($total_refund != 0)
            <tr class="item">
                <td>Deposit Not Refunded</td>
                <td style="text-align: right">0</td>
                <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_refund)}}</td>
            </tr>
        @endif
        @if($total_resto != 0)
        <tr class="item">
            <td>Restaurant</td>
            <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_resto)}}</td>
            <td style="text-align: right">0</td>
        </tr>
        @endif
        @if($total_dp != 0)
        <tr class="item">
            <td>Room Down Payment</td>
            <td style="text-align: right">0</td>
            <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_dp)}}</td>
        </tr>
        @endif
        @if($total_extra_paid != 0)
            <tr class="item">
                <td>Extracharge Payment</td>
                <td style="text-align: right">0</td>
                <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_extra_paid)}}</td>
            </tr>
        @endif
        @if($total_final_paid != 0)
            <tr class="item">
                <td>Final Payment</td>
                <td style="text-align: right">0</td>
                <td style="text-align: right">{{\App\Helpers\GlobalHelper::moneyFormatReport($total_final_paid)}}</td>
            </tr>
        @endif
        <tr class="item">
            <td style="text-align: right"><b>Total</b></td>
            <td style="text-align: right"><b>{{\App\Helpers\GlobalHelper::moneyFormatReport($total_debit)}}</b></td>
            <td style="text-align: right"><b>{{\App\Helpers\GlobalHelper::moneyFormatReport($total_credit)}}</b></td>
        </tr>
        <tr class="item">
            <td style="text-align: right"><b>Balance</b></td>
            <td style="text-align: right"><b>{{\App\Helpers\GlobalHelper::moneyFormatReport($total_balance)}}</b></td>
            <td><b>RUPIAH</b></td>
        </tr>
        <tr>
            <td style="font-style: italic;font-size: 12px" colspan="4">All Price includes Government Tax ({{$tax}}%) and Service ({{$service}}%)</td>
        </tr>
        <tr style="line-height: 0px">
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">
                <table>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <span style="display: block;margin-bottom: 100px;margin-right: 20px">Guest Name</span>
                            <span>{{ucfirst($name)}}</span>
                            <hr>
                        </td>
                        <td colspan="2" style="text-align: center">
                            <span style="display: block;margin-bottom: 100px;margin-right: 20px">Front Office</span>
                            <span style="text-align: center">{{ucfirst($admin)}}</span>
                            <hr>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div style="clear: both;margin-bottom: 10px"></div>
<div style="text-align: center">
    <button id="buttonprint" style="font-size: 18px;padding: 10px 20px;margin-top: 20px;text-align: center" onclick="window.print()">Print</button>
</div>
</body>
</html>
