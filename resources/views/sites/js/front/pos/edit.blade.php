<script>
    $(function() {
        $('#date').datepicker({
            dateFormat : 'yy-mm-dd'
        });

        $('input[type=radio][name=is_guest]').change(function() { // GUEST NOT GUEST
            if (this.value == '1') {
                $('#guest-cont').show();
            }
            else if (this.value == '0') {
                $('#guest-cont').hide();
                $('#guest_name').val('');
                $('#guest_id').val('');
            }
        });

        $('input[type=number]').focusin(function () {
            if($(this).val() == 0){
               $(this).val('');
            }
        });


        function searchGuest (elem) {
            var id = elem.data("id");
            var first_name = elem.data("firstname");
            var last_name = elem.data("lastname");

            $('#guest_name').val(first_name+' '+last_name);
            $('#guest_id').val(id);
        };

        $('.chooseGuest').click(function(){
            searchGuest($(this));
        });

        function chooseItem (elem) {
            var id = elem.data("id");
            var name = elem.data("name");
            var price = elem.data("price");
            var grand_total = $('#grand_total').val();

            $('#list-data').prepend('<tr id="item-'+id+'">' +
                    '<td>'+name+'</td>' +
                    '<td>'+toMoney(price)+'</td>' +
                    '<td><input type="number" name="qty['+id+']" onchange="changeQty($(this))" onkeyup="changeQty($(this))" id="qty-'+id+'" data-id="'+id+'" class="qtyItem" value="1" size="1" style="width: 30px" /><input type="hidden" name="price['+id+']" id="price-'+id+'" value="'+price+'" /></td>' +
                    '<td id="discount-'+id+'"><input type="number" name="discount['+id+']" onchange="changeDiscount($(this))" onkeyup="changeDiscount($(this))" data-id="'+id+'" value="0" style="width: 80px" /></td>' +
                    '<input type="hidden" name="subtotal['+id+']" id="subtotal-'+id+'" value="'+price+'" />' +
                    '<td><span id="total-'+id+'">'+toMoney(price)+' &nbsp;</span> <a id="deleteCart-'+id+'" onclick="deleteCart($(this))" data-id="'+id+'" data-price="'+price+'"><i class="icon-2x icon-remove"></i></a></td></tr>'
            );

            calculateGrandTotal(price, 'plus');
        }

        $('.chooseItem').click(function(){
            chooseItem($(this));
        });

        $('#searchGuestForm').submit(function(){
            var filter = $('#searchguest').val();
            var listGuest = [];
            $.ajax({
                type  : "POST",
                data    : $(this).serialize(),
                url     : "{{route('ajax.searchGuest')}}",
                success : function(result){
                    $('#listGuest').html("");
                    obj = JSON.parse(result);
                    i = 0;
                    $.each(obj, function(key, value) {
                        i++;
                        rowType = (i % 2 == 1) ? 'odd' : 'even';
                        listGuest.push('<tr class="'+rowType+' gradeX">');
                        listGuest.push('<td>'+value.first_name+' '+value.last_name+'</td>');
                        listGuest.push('<td>'+value.id_number+' ('+getIDTypeName(value.id_type)+')</td>');
                        listGuest.push('<td><a data-dismiss="modal" data-firstname="'+value.first_name+'" data-lastname="'+value.last_name+'"');
                        listGuest.push('data-id="'+value.guest_id+'"');
                        listGuest.push('data-handphone="'+value.handphone+'" class="btn btn-success chooseGuest">Choose</a></td>')
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
            $('#form-pos').submit();
        });

        $('#pay_paid').focusout(function () {
            var grand_total = parseInt($('#grand_total').val());
            var paid = parseInt($(this).val());
            var change = 0;
            console.log(paid);
            console.log(grand_total);

            if(paid < grand_total){
                alert('Paid amout must be bigger than billed amount');
            } else {
                change = paid - grand_total;
            }
            $('#pay_change').val(change);
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
        var grand_total = $('#grand_total').val();
        var is_guest = $('input[type=radio][name=is_guest]:checked').val();
        var billed = $('#billed').val();

        if(is_guest == 1){
            var guest_id = $('#guest_id').val();
            if(guest_id == '' || guest_id == '0'){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input guest data</div>');
            }
        }

        if(billed == 1){
            var payment_method = $('#payment_method').val();
            var pay_paid = $('#pay_paid').val();

            if(payment_method == 0){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please select payment method</div>');
            }

            if(parseInt(pay_paid) == 0){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input paid amount</div>');
            }

            if(parseInt(pay_paid) < parseInt(grand_total)){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Paid amount must be bigger than billed amount</div>');
            }
        }

        if(date == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please input transaction date</div>');
        }

        if(grand_total == '0'){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please select minimum 1 item</div>');
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

            var total = parseInt(elem.val()) * parseInt($('#price-'+id_item_qty).val());
            console.log($('#price-'+id_item_qty).val());
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
            alert('Discount cannot be bigger than total')
        }
        var total = parseInt($('#qty-'+id_item_qty).val()) * parseInt($('#price-'+id_item_qty).val()) - parseInt(disc);
        $('#total-'+id_item_qty).html(toMoney(total));
        $('#subtotal-'+id_item_qty).val(total);
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