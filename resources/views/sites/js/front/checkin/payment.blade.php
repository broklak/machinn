<script>
    $(function() {

        $('#card_expired_date').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm yy',
            onClose: function (dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });

        $('#payment_method').change(function () {
            var payment = $(this).val();

            if (payment == 1 || payment == 2) {
                $('#cc-container').hide();
                $('#bt-container').hide();
            } else {
                if (payment == 3) {
                    $('#cc-container').show();
                    $('#bt-container').hide();
                } else {
                    $('#bt-container').show();
                    $('#cc-container').hide();
                }
            }
        });

        $('#form-payment').submit(function () {
            $('#error_messages').html("");
            return validateOnSubmit();
        });

        function validateOnSubmit() {
            var err = 0;
            var payment_method = $('#payment_method').val();

            if (payment_method == 0) {
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please select payment method</div>');
            }

            if(payment_method == 3){
                var number = $('#card_number').val();
                var holder = $('#card_holder').val();
                var expired = $('#card_expired_date').val();
                var type = $('#cc_type').val();
                var bank = $('#bank').val();

                if (number == '') {
                    err = 1;
                    $('#error_messages').append('<div class="alert alert-error">Please input card number</div>');
                }

                if (holder == '') {
                    err = 1;
                    $('#error_messages').append('<div class="alert alert-error">Please input card holder</div>');
                }

                if (expired == '') {
                    err = 1;
                    $('#error_messages').append('<div class="alert alert-error">Please input card expired date</div>');
                }

                if (type == 0) {
                    err = 1;
                    $('#error_messages').append('<div class="alert alert-error">Please input card type</div>');
                }

                if (bank == 0) {
                    err = 1;
                    $('#error_messages').append('<div class="alert alert-error">Please input card bank issuer</div>');
                }
            }

            if(payment_method == 4){
                var cash_account = $('#cash_account_id').val();
                if (cash_account == 0) {
                    err = 1;
                    $('#error_messages').append('<div class="alert alert-error">Please input cash account recipient</div>');
                }
            }

            if (err == 1) {
                $('#error_messages').goTo();
                return false;
            } else {
                return true;
            }
        }

        $.fn.goTo = function () {
            $('html, body').animate({
                scrollTop: $(this).offset().top - 80 + 'px'
            }, 'slow');
            return this; // for chaining...
        }
    });

    function formatMoney(elem) {
        var n = parseInt(elem.val().replace(/\D/g, ''), 10);

        if (isNaN(n)) {
            elem.val('0');
        } else {
            elem.val(n.toLocaleString());
        }
    }

</script>