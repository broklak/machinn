<script>
    $(function() {
        $('#date').datepicker({
            dateFormat : 'yy-mm-dd'
        });

        $('input[type=radio][name=delivery_type]').change(function() { // DINE IN OR ROOM SERVICE
            if (this.value == '1') { // DINE IN
                $('#guest-type-cont').show();
                $('#guest-num-cont').show();
                $('#table-cont').show();
                $('#guest-cont').hide();
                $('#room-cont').hide();
                $('#bill-cont').hide();
            }
            else if (this.value == '2') { // ROOM SERVICE
                $('#guest-type-cont').hide();
                $('#guest-cont').show();
                $('#guest-num-cont').hide();
                $('#table-cont').hide();
                $('#room-cont').show();
                $('#bill-cont').show();
            }
        });

        $('input[type=radio][name=is_guest]').change(function() { // GUEST NOT GUEST
            if (this.value == '1') {
                $('#guest-cont').show();
                $('#bill-cont').show();
                $('#room-cont').show();
            }
            else if (this.value == '0') {
                $('#guest-cont').hide();
                $('#bill-cont').hide();
                $('#room-cont').hide();
                $('#guest_name').val('');
                $('#guest_id').val('');
                $('#room_code').val('');
                $('#room_id').val('');
            }
        });

        $('input[type=number]').focusin(function () {
            if($(this).val() == '0'){
                $(this).val('');
            }
        });

        function searchGuest (elem) {
            var id = elem.data("id");
            var first_name = elem.data("firstname");
            var last_name = elem.data("lastname");
            var room_code = elem.data("roomcode");
            var room_id = elem.data("room");
            var booking_id = elem.data("booking");

            $('#guest_name').val(first_name+' '+last_name);
            $('#guest_id').val(id);
            $('#room_id').val(room_id);
            $('#room_code').val(room_code);
            $('#booking_id').val(booking_id);
        };

        $('.chooseGuest').click(function(){
           searchGuest($(this));
        });

        function chooseItem (id, name, price, qty) {
            var grand_total = $('#grand_total').val();
            if(qty < 1){
              alert('@lang('msg.invalidQty')')
            } else {
              $('#list-data').prepend('<tr id="item-'+id+'">' +
                      '<td>'+name+'</td>' +
                      '<td>'+toMoney(price)+'</td>' +
                      '<td><input type="number" name="qty['+id+']" onchange="changeQty($(this))" onkeyup="changeQty($(this))" id="qty-'+id+'" data-id="'+id+'" class="qtyItem" value="1" size="1" style="width: 30px" /><input type="hidden" name="price['+id+']" id="price-'+id+'" value="'+price+'" /></td>' +
                      '<td><input type="number" name="discount['+id+']" onchange="changeDiscount($(this))" onkeyup="changeDiscount($(this))" data-id="'+id+'" value="0" style="width: 80px" /></td>' +
                      '<input type="hidden" id="discount-'+id+'" value="0" />' +
                      '<input type="hidden" name="subtotal['+id+']" id="subtotal-'+id+'" value="'+price+'" />' +
                      '<td><span id="total-'+id+'">'+toMoney(price)+' &nbsp;</span> <a id="deleteCart-'+id+'" onclick="deleteCart($(this))" data-id="'+id+'" data-price="'+price+'"><i class="icon-2x icon-remove"></i></a></td></tr>'
              );

              calculateGrandTotal(price, 'plus');
              $('input[type=number]').focusin(function () {
                  if($(this).val() == '0'){
                      $(this).val('');
                  }
              });
            }
        }

        $("#menu").on('input', function () {
            var val = this.value;
            var selected = $('#menu-list').find('option').filter(function(){
                return this.value.toLowerCase() === val.toLowerCase();
            });

            if(selected.length) {
                var name = val;
                var price = selected.data('price');
                var id = selected.data('id');
                var qty = selected.data('qty');

                chooseItem(id, name, price, qty);

                $(this).val('');
            }
        });

        $('#searchGuestForm').submit(function(){
            var filter = $('#searchguest').val();
            var listGuest = [];
            $.ajax({
                type  : "POST",
                data    : $(this).serialize(),
                url     : "{{route('ajax.searchInhouseGuest')}}",
                success : function(result){
                    $('#listGuest').html("");
                    obj = JSON.parse(result);
                    i = 0;
                    $.each(obj, function(key, value) {
                        i++;
                        rowType = (i % 2 == 1) ? 'odd' : 'even';
                        listGuest.push('<tr class="'+rowType+' gradeX">');
                        listGuest.push('<td>'+value.first_name+' '+value.last_name+'</td>');
                        listGuest.push('<td>'+value.room_number_code+'</td>');
                        listGuest.push('<td><a data-dismiss="modal" data-firstname="'+value.first_name+'" data-lastname="'+value.last_name+'"');
                        listGuest.push('data-id="'+value.guest_id+'" data-room="'+value.room_number_id+'" data-roomcode="'+value.room_number_code+'"');
                        listGuest.push('data-booking="'+value.booking_id+'"');
                        listGuest.push('class="btn btn-success chooseGuest">@lang('web.choose')</a></td>')
                        listGuest.push('</tr>');
                    });
                    listElement = listGuest.join(" ");
                    $('#listGuest').html(listElement);

                    $('.chooseGuest').click(function(){
                        searchGuest($(this));
                    });
                }
            });

            return false;
        });

        $('#form-pos').submit(function(){
            $('#error_messages').html("");
            return validateOnSubmit();

        });

        $('#payment_method').change(function(){
            var payment = $(this).val();

            if(payment == 1 || payment == 2){
                $('#cc-container').hide();
                $('#bt-container').hide();
            } else{
                if(payment == 3){
                    $('#cc-container').show();
                    $('#bt-container').hide();
                } else {
                    $('#bt-container').show();
                    $('#cc-container').hide();
                }
            }
        });

        $('#billedButton').click(function () {
            $('#saveType').val('2');
            $('#error_messages').html("");
            var validate = validateOnSubmit();
            if(validate){
                $('#form-pos').submit();
            }
        })
    });

    function getIDTypeName (type){
        if(type == 1){
            return 'KTP';
        } else if(type == 2) {
            return 'SIM';
        } else {
            return 'PASSPORT';
        }
    }

    function toMoney(num) {
        return 'IDR '+num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }

    function validateOnSubmit(){
        var err = 0;
        var date = $('#date').val();
        var guest_num = $('#guest_num').val();
        var table = $('#table_id').val();
        var grand_total = $('#grand_total').val();
        var is_guest = $('input[type=radio][name=is_guest]:checked').val();
        var delivery_type = $('input[type=radio][name=delivery_type]:checked').val();

        if(delivery_type == undefined){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.transactionTypeNull')</div>');
        }

        if(delivery_type == 1){
            if(guest_num == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">@lang('msg.numberGuestNull')</div>');
            }

            if(table == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">@lang('msg.tableNumberNull')</div>');
            }
        }

        if(delivery_type == 2){
            var guest_id = $('#guest_id').val();
            if(guest_id == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">@lang('msg.guestDataNull')</div>');
            }
        }

        if(is_guest == 1){
            var guest_id = $('#guest_id').val();
            if(guest_id == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">@lang('msg.guestDataNull')</div>');
            }
        }

        if(date == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.transactionDateNull')</div>');
        }

        if(grand_total == '0'){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">@lang('msg.minimumOneItem')</div>');
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
        console.log(disc + '-' +subtotal +'-' +total);
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
</script>
