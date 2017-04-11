<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$hotel_name}} Payment Receipt</title>

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

        .invoice-box table tr td:nth-child(2){
            text-align:right;
        }

        .invoice-box table tr.top table td{
            padding-bottom:10px;
        }

        .invoice-box table tr.top table td.title{
            font-size:20px;
            color:#333;
            text-align: center;
        }

        .invoice-box table tr.information table td{
            padding-bottom:20px;
        }

        .invoice-box table tr.heading td{
            background:#eee;
            border-bottom:1px solid #ddd;
            font-weight:bold;
        }

        .invoice-box table tr.details td{
            padding-bottom:20px;
        }

        .invoice-box table tr.item td:first-child{
            border-left:1px solid #000;
        }

        .invoice-box table tr.item td{
            /*font-size: 10px;*/
            border-top:1px solid #000;
            border-right:1px solid #000;
        }

        .invoice-box table tr.item.last td{
            border-bottom:1px solid #000;
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
            <td colspan="2">
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
            <td colspan="2">
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
                        <td colspan="2" style="text-align: center"><h2>RECEIPT</h2></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="item">
            <td>
                Booking Code
            </td>

            <td>
                {{$header->booking_code}}
            </td>
        </tr>

        <tr class="item">
            <td>
                Bill Number
            </td>

            <td>
                {{$bill_number}}
            </td>
        </tr>

        <tr class="item">
            <td>
                Received From
            </td>

            <td>
                {{$name}}
            </td>
        </tr>

        <tr class="item last">
            <td>
                Total
            </td>

            <td>
                {{$total}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 5px;width: 40%;float: right">
        <span style="margin-left: 15%;margin-top: 20px;margin-bottom: 100px;display: block">{{$date}}</span>
        <span style="margin-left: 35%">{{ucfirst($admin)}}</span>
        <hr>
    </div>
</div>
<div style="clear: both;margin-bottom: 10px"></div>
<div style="text-align: center">
    <button id="buttonprint" style="font-size: 18px;padding: 10px 20px;margin-top: 20px;text-align: center" onclick="window.print()">Print</button>
</div>
</body>
</html>
