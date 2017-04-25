
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"><title>Panel Centro City Residence - Nota Pembayaran</title>
    <script type="text/javascript">
        function silentPrint(printer)
        {
            //document.getElementById("myForm").submit();


            if (typeof(jsPrintSetup) == 'undefined')
            {
                installjsPrintSetup();
            }
            else
            {

                alert('Cetak berhasil dilakukan');
                $("#"+printer).attr("disabled", true);
                $("#"+printer).css("color","#ccc");
                // set page orientation.
                // jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
                // jsPrintSetup.setGlobalOption('paperWidth', 210);
                // jsPrintSetup.setGlobalOption('paperHeight', 297);

                // Define paper size. (To be A4)
                //jsPrintSetup.setPaperSizeData(9);
                // jsPrintSetup.definePaperSize(9, 9, 'iso_a4', 'iso_a4_210x297mm', 'A4', 210, 297, jsPrintSetup.kPaperSizeMillimeters);

                //set margins.
                jsPrintSetup.setOption('marginTop', 0);
                jsPrintSetup.setOption('marginBottom', 0);
                jsPrintSetup.setOption('marginLeft', 0);
                jsPrintSetup.setOption('marginRight', 0);

                //set page header
                jsPrintSetup.setOption('headerStrLeft', '');
                jsPrintSetup.setOption('headerStrCenter', '');
                jsPrintSetup.setOption('headerStrRight', '');
                //set empty page footer
                jsPrintSetup.setOption('footerStrLeft', '');
                jsPrintSetup.setOption('footerStrCenter', '');
                jsPrintSetup.setOption('footerStrRight', '');

                // set the printer (based on your printer name)
                jsPrintSetup.setPrinter(printer);

                // sets silent printing (skip the print settings dialog box)
                jsPrintSetup.setSilentPrint(true);

                // print the page
                jsPrintSetup.print();

                document.getElementById("myForm").submit();

            }

        }
        // Install JSPrintSetup
        function installjsPrintSetup() {
            if (confirm("You don't have printer plugin.\nDo you want to install the Printer Plugin now?")) {
                var xpi = new Object();
                xpi['jsprintsetup'] = './librari/jsPrintSetup/js_print_setup.xpi';
                InstallTrigger.install(xpi);
            }
        }


    </script>
</head>
<body style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">

<style type="text/css" media="print,screen,projection">
    html, *{
        margin:0;
        padding: 0;
        vertical-align: baseline;
    }
    body{
        font-family: Tahoma;
    }
    .container{
        width: 250px;
        height: auto;
        min-height: 300px;
        background: transparent;
        /*border:1px dashed #ccc;*/
        margin:0 0 5px;
        padding:0 10px 10px;
        position: absolute;
        top: 0;
    }
    #hidden_screenshot{
        width: 250px;
    }
    div.divider{
        width: 100%;
        height: 5px;
        margin: 5px 0;
    }
    .nota-header{
        width: 100%;
        height: auto;
        text-align: center;
        margin: 10px 0;
    }
    .nota-header2 table{
        font-size: 11px;
        width: 100%;
    }
    .nota-description{
        text-transform: uppercase;
        font-size: 10px;
        line-height:18px;
    }
    .nota-info{
        font-size: 10px;
    }
    .nota-header h4{
        text-transform: uppercase;
        font-weight: normal;
    }

    .nota-body{
        width: 100%;
        height: auto;
        margin: 10px 0;
    }
    table{
        font-size: 10px;
        width: 100%;
        border-collapse: collapse;
        color: #333
    }
    .nota-body table tr td,
    .nota-body table tr th{
        padding:5px 2px;

    }
    .nota-body table.transaction-list tr th{
        text-align: left;
        border-top:1px dashed #333;
        border-bottom:1px dashed #333;

    }
    .nota-body table.transaction-list tr td{
        border-bottom:1px dashed #333;
    }
    .nota-body table.transaction-list tr td.text-right{
        text-align: right !important
    }
    .nota-body table.transaction-list tr.total td{
        border:none;
        padding: 0 2px
    }
    .nota-body table.transaction-list tr.total.netto td{
        padding: 7px 2px;

    }
    .nota-footer{
        width: 100%;
        height: auto;
        margin-top: 10px;
    }

    .nota-footer2{
        width: 100%;
        height: auto;
        margin-top: 20px;
    }
    .nota-footer2 table{
        font-size: 11px;
        width: 100%;
    }
    .border-top,
    tr.border-top td{
        border-top:1px dashed #333 !important;
    }
    .p-b,
    tr.p-b td{
        padding-bottom: 5px !important;
    }
    .p-t,
    tr.p-t td{
        padding-top: 5px !important;
    }

    .hide{
        display: none!important;
    }
    input.btn-print{
        display: none;
    }
    @media print{
        #buttonprint {
            display: none;
        }
    }
</style>



<script type="text/javascript">
    $(function(){
        $(".hide-print").on('click',function(){
            $(this).hide();
        })
    })
</script>


<div style="position:absolute;top:0;left:5;"><h1 id="title" style="display:none"> 1.8.0</h1></div>

<div class="hide"><input onClick="findPrinter()" value="Detect Printer" type="button">
    <input id="printer" value="dapur" size="15" type="text">
    <input onClick="findPrinters()" value="List All Printers" type="button">
    <input onClick="useDefaultPrinter()" value="Use Default Printer" type="button">
</div>
<!-- NEW QZ APPLET TAG USAGE -- RECOMMENDED -->
<!--
<applet id="qz" archive="./qz-print.jar" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
<param name="jnlp_href" value="qz-print_jnlp.jnlp">
<param name="cache_option" value="plugin">
<param name="disable_logging" value="false">
<param name="initial_focus" value="false">
</applet><br />
-->

<!-- OLD JZEBRA TAG USAGE -- FOR UPGRADES -->
<!--
<applet name="jzebra" archive="./qz-print.jar" code="qz.PrintApplet.class" width="55" height="55">
<param name="jnlp_href" value="qz-print_jnlp.jnlp">
<param name="cache_option" value="plugin">
<param name="disable_logging" value="false">
<param name="initial_focus" value="false">
<param name="printer" value="zebra">
</applet><br />
-->
<!-- Nota Container -->
<div class="container">

    <script type="text/javascript">
        var full = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');


        function popgrmguestid()
        {
            sList = window.open("index.php?pop=1&kanal=grm-guest&aksi=popupgrmguestid-checkin", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");

            //var res = window.showModalDialog("index.php?pop=1&kanal=grm-guest&aksi=popupgrmguestid-checkin","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
            if (sList != null)
            {
                $(".tr_roomid").show();
                /*document.getElementById("grmguestid").value      = res.grmguestid;
                 document.getElementById("grmguestid_text").value = res.grmguestid_text;
                 document.getElementById("roomid").value          = res.grmguestid_roomid;
                 document.getElementById("roomid_text").value     = res.grmguestid_room;
                 document.getElementById("folio_number").value    = res.grmguestid_folio_number;*/

                autosavedata();
            }
            return false;
        }
        function poproomid()
        {
            var res = window.showModalDialog("index.php?pop=1&kanal=room&aksi=popuproomid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
            if (res != null)
            {
                document.getElementById("roomid").value      = res.roomid;
                document.getElementById("roomid_text").value = res.roomid_text;

                autosavedata();
            }
            return false;
        }

        function cetak_menu_kitchen(id)
        {
            sList = window.open("index.php?kanal=fnb_dine_in&aksi=cetak_menu&tipe=kitchen&nota=1&id="+id, "list", "width=400,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");

            //var res = window.showModalDialog("index.php?&kanal=fnb_dine_in&aksi=cetak_menu&tipe=kitchen&nota=1&id="+id,"", "dialogWidth:245px;dialogHeight:500px;dialogTop:150px;")
            return false;
        }
        function cetak_menu_bev(id)
        {
            sList = window.open("index.php?kanal=fnb_dine_in&aksi=cetak_menu&tipe=beverages&nota=1&id="+id, "list", "width=400,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
            /*var res = window.showModalDialog("index.php?&kanal=fnb_dine_in&aksi=cetak_menu&tipe=beverages&nota=1&id="+id,"", "dialogWidth:245px;dialogHeight:500px;dialogTop:150px;")
             if (res != null)
             {
             document.getElementById("roomid").value      = res.roomid;
             document.getElementById("roomid_text").value = res.roomid_text;
             }*/
            return false;
        }

        function nota(id)
        {
            sList = window.open("index.php?kanal=fnb_dine_in&aksi=nota_tagihan&nota=1&id="+id, "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
            /*var res = window.showModalDialog("index.php?&kanal=fnb_dine_in&aksi=nota_tagihan&nota=1&id="+id,"", "dialogWidth:245px;dialogHeight:500px;dialogTop:150px;")
             if (res != null)
             {
             document.getElementById("roomid").value      = res.roomid;
             document.getElementById("roomid_text").value = res.roomid_text;
             }*/
            return false;
        }

        function kwitansi(id)
        {
            var id = $("input[name=foliofnbid]").val();

            sList = window.open("index.php?kanal=fnb_dine_in&aksi=kwitansi&nota=1&cetak=1&id="+id, "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
            /*var res = window.showModalDialog("index.php?&kanal=fnb_dine_in&aksi=kwitansi&nota=1&cetak=1&id="+id,"", "dialogWidth:245px;dialogHeight:500px;dialogTop:150px;")
             if (res != null)
             {
             document.getElementById("roomid").value      = res.roomid;
             document.getElementById("roomid_text").value = res.roomid_text;
             }*/
            return false;
        }

        function popuppaymentsettlementid()
        {
            sList = window.open("index.php?pop=1&kanal=payment-settlement&aksi=popuppaymentsettlementid", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
            /*var res = window.showModalDialog("index.php?pop=1&kanal=payment-settlement&aksi=popuppaymentsettlementid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
             if (res != null)
             {
             document.getElementById("paymentsettlementid").value 		= res.paymentsettlementid;
             document.getElementById("paymentsettlementid_text").value 	= res.paymentsettlementid_text;
             }*/
            return false;
        }

        function popupswipecard()
        {
            sList = window.open("index.php?pop=1&kanal=kasir-pembayaran&aksi=popupswipecard", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
            //var res = window.showModalDialog("index.php?pop=1&kanal=kasir-pembayaran&aksi=popupswipecard","", "dialogWidth:400px;dialogHeight:380px;dialogTop:200px;")
            if (sList != null)
            {
                sList.holder = $.trim(sList.holder);
                if (sList.holder != '') {
                    $('#cardholder').val(sList.holder);
                }
                $('#cardnumber').val(sList.number);
                $('select[name="expbulan"]').val(sList.month);
                $('select[name="exptahun"]').val(sList.year);
            }
            return false;
        }


        function popfnbtableid()
        {
            sList = window.open("index.php?pop=1&kanal=fnb_table&aksi=popupfnbtableid", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
            if (sList != null)
            {
                autosavedata();
            }
            return false;
        }


    </script>

    <!-- Nota header -->

    <div class="nota-header">
        <img src="{{(session('logo') == null) ? asset('img/matrix/no_image.png') : asset('storage/img/matrix/'.session('logo')) }}" width="60%">
        {{--<p style="font-size:9px;"></p>--}}
    </div>
    <!-- Nota Body -->
    <div class="nota-body">
        <table>
            <tr>
                <td>Bill Number</td>
                <td>: {{$header->bill_number}}</td>
            </tr>
            <tr>
                <td>Transaction Time</td>
                <td>: {{date('Y-m-d H:i:s')}}</td>
            </tr>
            <tr>
                @if($header->delivery_type == 1)
                    <td>Table</td>
                    <td>: {{$header->table_id}} </td>
                @else
                    <td>Room</td>
                    <td>: {{\App\RoomNumber::getCode($header->room_id)}} </td>
                @endif
            </tr>
        </table>
        <div class="divider"></div>
        <table class="transaction-list">
            <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detail as $key => $val)
                <tr>
                    <td>{{\App\PosItem::getName($val->extracharge_id)}}</td>
                    <td>{{$val->qty}}  </td>
                    <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->price)}} </td>
                    <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->discount)}} </td>
                    <td class="text-right">{{\App\Helpers\GlobalHelper::moneyFormatReport($val->subtotal)}}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" class="text-right"> Total :</td>
                <td class=" border-bottom">Rp </td>
                <td class="text-right border-top">{{\App\Helpers\GlobalHelper::moneyFormatReport($header->total_billed)}}</td>
            </tr>
            <tr class="total ">
                <td colspan="3" class="text-right" >{{\App\PosTax::getServiceInfo()}} :</td>
                <td class=" border-bottom">Rp </td>
                <td class="text-right ">{{\App\Helpers\GlobalHelper::moneyFormatReport($header->total_service)}}</td>
            </tr>
            <tr class="total" >
                <td colspan="3" class="text-right">{{\App\PosTax::getTaxInfo()}}:</td>
                <td class=" border-bottom">Rp </td>
                <td class="text-right ">{{\App\Helpers\GlobalHelper::moneyFormatReport($header->total_tax)}}</td>
            </tr>
            {{--<tr class="total">--}}
                {{--<td colspan="3" class="text-right">Round :</td>--}}
                {{--<td class=" border-bottom">Rp </td>--}}
                {{--<td class="text-right border-bottom">0</td>--}}
            {{--</tr>--}}

            <tr class="total netto" style="font-size:14px">
                <td colspan="3" class="text-right">Grand Total :</td>
                <td class=" border-bottom">Rp </td>
                <td class="text-right">{{\App\Helpers\GlobalHelper::moneyFormatReport($header->grand_total)}}</td>
            </tr>
            {{--<tr class="total border-top p-t"><td colspan="4">Pembayaran</td></tr>--}}
            {{--<tr class="total">--}}
                {{--<td colspan="2">Cash</td>--}}
                {{--<td>Rp </td>--}}
                {{--<td class="text-right">35.800</td>--}}
            {{--</tr>--}}
            {{--<tr class="total netto">--}}
                {{--<td colspan="2">Kembalian</td>--}}
                {{--<td>Rp </td>--}}
                {{--<td class="text-right">0,00</td>--}}
            {{--</tr>--}}

            </tbody>
        </table>
    </div>
    <!-- Nota Footer -->
    {{--<div class="nota-footer">--}}
        {{--<table>--}}
            {{--<tr>--}}
                {{--<td width="40%">Nomor Meja</td>--}}
                {{--<td>: Meja 1</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td>Guest Name</td>--}}
                {{--<td>: </td>--}}
            {{--</tr>--}}
        {{--</table>--}}
    {{--</div>--}}

    <div class="divider"></div>
    <div class="nota-header">
        <p class="nota-description">Thank you for your visit</p>
    </div>		 <br>
    <div style="text-align: center;clear: both">
        <button id="buttonprint" style="font-size: 18px;padding: 10px 20px;margin-top: 20px;text-align: center" onclick="window.print()">Print</button>
    </div>
</div>
<!--- /Nota Container -->
</body>
</html>