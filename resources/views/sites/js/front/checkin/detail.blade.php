<script>
    $(function() {
        $('input[type=number]').focusin(function () {
            if($(this).val() == 0){
                $(this).val('');
            }
        });

        function chooseItem (elem) {
            var id = elem.data("id");
            var name = elem.data("name");
            var price = elem.data("price");
            var grand_total = $('#grand_total').val();
            var roomList = '{{$header->room_list}}'.trim();
            var roomCodeList = '{{\App\RoomNumber::getRoomCodeList($header->room_list)}}'.trim();
            var room = roomList.split(',');
            var roomCode = roomCodeList.split(',');
            var roomOpt = [];

            for(i=0;i < room.length; i++){
                roomOpt.push('<option value="'+room[i]+'">'+roomCode[i]+'</option>')
            }
            var optElem = roomOpt.join(' ');

            $('#list-data').prepend('<tr id="item-'+id+'">' +
                    '<td>{{date('j F Y')}}</td>' +
                    '<td><select style="width:80px" name="room_id['+id+']">'+optElem+'</select></td>' +
                    '<td>'+name+'</td>' +
                    '<td>'+toMoney(price)+'</td>' +
                    '<td><input type="number" name="qty['+id+']" onchange="changeQty($(this))" onkeyup="changeQty($(this))" id="qty-'+id+'" data-id="'+id+'" class="qtyItem" value="1" size="1" style="width: 30px" /><input type="hidden" name="price['+id+']" id="price-'+id+'" value="'+price+'" /></td>' +
                    '<td><input type="number" name="discount['+id+']" onchange="changeDiscount($(this))" onkeyup="changeDiscount($(this))" data-id="'+id+'" value="0" style="width: 80px" /></td>' +
                    '<input type="hidden" id="discount-'+id+'" value="0" />' +
                    '<input type="hidden" name="subtotal['+id+']" id="subtotal-'+id+'" value="'+price+'" />' +
                    '<td><span id="total-'+id+'">'+toMoney(price)+' &nbsp;</span> <a id="deleteCart-'+id+'" onclick="deleteCart($(this))" data-id="'+id+'" data-price="'+price+'"><i class="icon-2x icon-remove"></i></a></td></tr>'
            );

            calculateGrandTotal(price, 'plus');
        }

        $('.chooseItem').click(function(){
            chooseItem($(this));
        });

        $('#searchItemForm').submit(function(){
            var filter = $('#searchitem').val();
            var listGuest = [];
            $.ajax({
                type  : "POST",
                data    : $(this).serialize(),
                url     : "{{route('ajax.searchItem')}}",
                success : function(result){
                    $('#listItem').html("");
                    obj = JSON.parse(result);
                    i = 0;
                    $.each(obj, function(key, value) {
                        i++;
                        rowType = (i % 2 == 1) ? 'odd' : 'even';
                        listGuest.push('<tr class="'+rowType+' gradeX">');
                        listGuest.push('<td>'+value.extracharge_name+'</td>');
                        listGuest.push('<td>'+toMoney(value.extracharge_price)+'</td>');
                        listGuest.push('<td><a data-dismiss="modal" data-id="'+value.extracharge_id+'" data-name="'+value.extracharge_name+'" data-price="'+value.extracharge_price+'" class="btn btn-success chooseItem">Choose</a></td>');
                        listGuest.push('</tr>');
                    });
                    listElement = listGuest.join(" ");
                    $('#listItem').html(listElement);

                    $('.chooseItem').click(function(){
                        chooseItem($(this));
                    });
                }
            });
            return false;
        });

        // EDIT ROOM

        $( document ).ready(function() {
            var checkin = $('#checkin').val();
            var checkout = $('#checkout').val();

            getAvailableRoom(checkin, checkout);
        });

        $('.removeRoom').click(function(e){
            removeRoom($(this));
            e.preventDefault();
        });

        $('#checkout').datepicker({
            dateFormat : 'yy-mm-dd',
            onSelect: function (selectedDate) {
                resetRoom();
                var date = $(this).datepicker('getDate');
                if (date) {
                    date.setDate(date.getDate() - 1);
                }
                $('#checkin').datepicker('option', 'maxDate', date || 0);

                var checkin = $('#checkin').val();
                var checkout = $('#checkout').val();

                getAvailableRoom(checkin, checkout);
            }
        });

        $('#searchRoomForm').submit(function(){
            var checkin = $('#checkin').val();
            var checkout = $('#checkout').val();
            var type = $('#room_type_filter').val();
            var floor = $('#floor_filter').val();

            getAvailableRoom(checkin, checkout, type, floor);

            return false;
        });

        $('#form-booking').submit(function(){
            $('#error_messages').html("");
            return validateOnSubmitRoom();
        });
    });

    function getAvailableRoom (dateIn, dateOut, type, floor) {
        var listRoom = [];
        $.ajax({
            type     : 'GET',
            data     : {"checkin" : dateIn, "checkout" : dateOut, "type" : type, "floor" : floor},
            url      : "{{route('ajax.searchRoom')}}",
            success  : function(result) {
                $('#listRoom').html(result);

                $('.chooseRoom').click(function(){
                    chooseRoom($(this));
                });
            }
        });
    }

    function chooseRoom (elem){
        var id = elem.data('id');
        var code = elem.data('code');
        var selectedRoom = $('#room_number').val();
        var roomList = selectedRoom.split(",");
        var rateWeekdays = elem.data('weekdays');
        var rateWeekends = elem.data('weekends');
        var type = elem.data("type");
        var typeName = elem.data("typename");
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();

        if($.inArray(id.toString(), roomList) !== -1){ // ALREADY SELECTED
            alert("Room Number "+code+' is already selected');
        } else { // NOT YET SELECTED
            roomList.push(id);
            joinRoom = roomList.join(',');
            $('#room_number').val(joinRoom);

            // GET TOTAL ROOM RATES
            var action = 'plus';
            getTotalRoomRate(checkin, checkout, rateWeekdays, rateWeekends, type, action);
            $('#list-room').append('' +
                    '<tr><td>'+code+'</td>' +
                    '<td>'+typeName+'</td>' +
                    '<td>'+toMoney(rateWeekdays)+'</td>' +
                    '<td>'+toMoney(rateWeekends)+'</td>' +
                    '<td><a href="#" title="Click to remove room" class="btn btn-danger removeRoom" data-id="'+id+'" ' +
                    'data-code="'+code+'" data-type="'+type+'" data-weekendrate="'+rateWeekends+'" data-weekdayrate="'+rateWeekdays+'" ' +
                    '><i class="icon-remove"></i> Remove Room</a></td></tr>');
            alert("Room Number "+code+' is selected');

            $('.removeRoom').click(function(e){
                removeRoom($(this));
                e.preventDefault();
            });
        }
    }

    function getTotalRoomRate (checkinDate, checkoutDate, weekdayRate, weekendRate, roomType, action){
        var totalRates = $('#total_rates').val();
        $.ajax({
            type    : 'GET',
            data    : {"type" : roomType, "rateWeekdays" : weekdayRate, "rateWeekends" : weekendRate, "checkin" : checkinDate, "checkout" : checkoutDate, "totalRates" : totalRates, "action" : action},
            url     : "{{route('ajax.getTotalRoomRates')}}",
            success : function(result){
                obj = JSON.parse(result);
                $('#total_rates').val(obj.total_rates);
                $('#booking_rate').val(toMoney(obj.total_rates));
            }
        });
    }

    function removeRoom (elem) {
        var totalRates = $('#total_rates').val();
        var id = elem.data('id');
        var code = elem.data('code');
        var selectedRoom = $('#room_number').val();
        var roomList = selectedRoom.split(",");
        var type = elem.data("type");
        var weekend = elem.data("weekendrate");
        var weekday = elem.data("weekdayrate");
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();
        var index = $.inArray(id.toString(), roomList);

        var action = 'minus';
        getTotalRoomRate(checkin, checkout, weekday, weekend, type, action);

        if (index > -1) {
            roomList.splice(index, 1);
        }
        elem.parents('tr').remove();
        joinRoom = roomList.join(',');
        $('#room_number').val(joinRoom);
    }

    function resetRoom () {
        $('#total_rates').val("");
        $('#booking_rate').val("");
        $('#list-room').html("");
        $('#room_number').val("");
    }

    function validateOnSubmitRoom(){
        var err = 0;
        var room_plan = $('#room_plan_id').val();
        var partner_id = $('#partner_id').val();
        var checkout = $('#checkout').val();
        var room = $('#room_number').val();

        if(room_plan == 0){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.roomPlanNull')</div>');
        }
        if(partner_id == 0){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.sourceNull')</div>');
        }
        if(checkout == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.checkoutDateNull')</div>');
        }
        if(room == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.roomNull')</div>');
        }

        if(err == 1){
            $('#error_messages').goTo();
            return false;
        } else {
            return true;
        }
    }

    function toMoney(num) {
        return 'Rp. '+num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }

    function validateOnSubmit(){
        var err = 0;
        var grand_total = $('#grand_total').val();

        if(grand_total == '0'){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('web.minimumOneItem')</div>');
        }

        if(err == 1){
            $('#error_messages').goTo();
            return false;
        } else {
            return true;
        }
    }

    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 80 + 'px'
        }, 'slow');
        return this; // for chaining...
    }

    function deleteCart(elem){;
        var id_item = elem.data('id');
        var id_item_price = $('#subtotal-'+id_item).val();
        $('#item-'+id_item).remove();
        calculateGrandTotal(id_item_price, 'minus');
    }

    function changeQty(elem){
        if(elem.val() != ''){
            var id_item_qty = elem.data('id');
            var subtotal = $('#subtotal-'+id_item_qty).val();

            // DELETE CURRENT SUBTOTAL FIRST
            calculateGrandTotal(subtotal, 'minus');

            var total = (parseInt(elem.val()) * parseInt($('#price-'+id_item_qty).val())) - parseInt($('#discount-'+id_item_qty).val());
            $('#total-'+id_item_qty).html(toMoney(total));
            $('#subtotal-'+id_item_qty).val(total);
            calculateGrandTotal(total, 'plus');
        }
    }

    function changeDiscount(elem){
        if(elem.val() != ''){
            disc = elem.val();
        } else {
            disc = 0;
        }
        var id_item_qty = elem.data('id');
        var subtotal = $('#subtotal-'+id_item_qty).val();
        calculateGrandTotal(subtotal, 'minus');
        if(parseInt(disc) > parseInt(subtotal)){
            disc = 0;
            elem.val(disc);
            alert('@lang('msg.discountBiggerTotal')')
        }
        var total = parseInt($('#qty-'+id_item_qty).val()) * parseInt($('#price-'+id_item_qty).val()) - parseInt(disc);
        $('#total-'+id_item_qty).html(toMoney(total));
        $('#subtotal-'+id_item_qty).val(total);
        $('#discount-'+id_item_qty).val(disc);
        calculateGrandTotal(total, 'plus');
    }

    function calculateGrandTotal (price, operation) {
        var grand_total = $('#grand_total').val();

        if(operation == 'plus'){
            grand_total = parseInt(grand_total) + parseInt(price);
        } else {
            grand_total = parseInt(grand_total) - parseInt(price);
        }
        $('#grand_total').val(grand_total);
        $('#grand_total_text').html(toMoney(grand_total));

        return grand_total;
    }

    function changeRate(elem){
        var id = elem.data('id');
        var rate = $('#room_rate_'+id).val();
        var subtotal = $('#subtotal_'+id).val();

        if(rate != ''){
            rate = rate;
        } else {
            rate = 0;
        }

        calculateGrandTotalRate(subtotal, 'minus');

        var subtotal_new = (parseInt(rate) + parseInt($('#plan_rate_'+id).val())) - parseInt($('#discount_'+id).val());
        $('#sub_text_'+id).html(toMoney(subtotal_new));
        $('#subtotal_'+id).val(subtotal_new);
        calculateGrandTotalRate(subtotal_new, 'plus');
    }

    function changePlan(elem){
        var id = elem.data('id');
        var rate = $('#plan_rate_'+id).val();
        var subtotal = $('#subtotal_'+id).val();

        if(rate != ''){
            rate = rate;
        } else {
            rate = 0;
        }

        calculateGrandTotalRate(subtotal, 'minus');

        var subtotal_new = (parseInt(rate) + parseInt($('#room_rate_'+id).val())) - parseInt($('#discount_'+id).val());
        $('#sub_text_'+id).html(toMoney(subtotal_new));
        $('#subtotal_'+id).val(subtotal_new);
        calculateGrandTotalRate(subtotal_new, 'plus');
    }

    function changeDiscountRate(elem){
        $('#discount_per_'+id).val('0');
        var id = elem.data('id');
        var rate = $('#discount_'+id).val();
        var subtotal = $('#subtotal_'+id).val();
        var subtotal_ori = $('#subtotal_ori_'+id).val();
        var percent = 0;
        if(rate != ''){
            rate = rate;
        } else {
            rate = 0;
        }

        calculateGrandTotalRate(subtotal, 'minus');

        var subtotal_new = parseInt($('#room_rate_'+id).val()) + parseInt($('#plan_rate_'+id).val()) - (parseInt(rate));

        percent = Math.round(rate / subtotal_ori * 100);
        $('#discount_per_'+id).val(percent);
        $('#sub_text_'+id).html(toMoney(subtotal_new));
        $('#subtotal_'+id).val(subtotal_new);
        calculateGrandTotalRate(subtotal_new, 'plus');
    }

    function changeDiscountRatePercent(elem){
        $('#discount_'+id).val('0');
        var id = elem.data('id');
        var ratePercent = $('#discount_per_'+id).val();
        var subtotal_ori = $('#subtotal_ori_'+id).val();
        var subtotal = $('#subtotal_'+id).val();

        if(ratePercent != ''){
            ratePercent = ratePercent;
        } else {
            ratePercent = 0;
        }

        calculateGrandTotalRate(subtotal, 'minus');

        rate = Math.round(subtotal_ori * (ratePercent / 100));

        var subtotal_new = parseInt($('#room_rate_'+id).val()) + parseInt($('#plan_rate_'+id).val()) - (rate);
        $('#discount_'+id).val(rate);
        $('#sub_text_'+id).html(toMoney(subtotal_new));
        $('#subtotal_'+id).val(subtotal_new);
        calculateGrandTotalRate(subtotal_new, 'plus');
    }

    function calculateGrandTotalRate (price, operation) {
        var grand_total = $('#grand_rate').val();
        if(operation == 'plus'){
            grand_total = parseInt(grand_total) + price;
        } else {
            grand_total = parseInt(grand_total) - price;
        }
        $('#grand_rate').val(grand_total);
        $('#grand_rate_text').html(toMoney(grand_total));

        return grand_total;
    }

    function formatMoney(elem) {
        var n = parseInt(elem.val().replace(/\D/g, ''), 10);

        if (isNaN(n)) {
            elem.val('0');
        } else {
            elem.val(n.toLocaleString());
        }
    }
</script>
