<script src="{{ asset("js") }}/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker();

    $('#invoice_id').change(function(){
        var amount = $(this).val();
        $('#amount').val($('#invoice_amount_'+cost).val());
    });
</script>