<script src="{{ asset("js") }}/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker();

    $('#cost_id').change(function(){
        var cost = $(this).val();
        $('#amount').val($('#cost_amount_'+cost).val());
    });

</script>