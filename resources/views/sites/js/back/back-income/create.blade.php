<script src="{{ asset("js") }}/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker();

    $('#income_id').change(function(){
        var id = $(this).val();
        $('#amount').val($('#income_amount_'+id).val());
    });
</script>