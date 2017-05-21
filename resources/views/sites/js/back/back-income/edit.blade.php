<script src="{{ asset("js") }}/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker();

    $('#income_id').change(function(){
        var id = $(this).val();
        $('#amount').val($('#income_amount_'+id).val());
    });

    $('#account_receivable_id').change(function(){
        var id = $(this).val();
        $('#amount').val($('#ar_amount_'+id).val());
    });

    $('#type').change(function(){
        var type = $(this).val();

        if(type == 3){
            $('#other').show();
            $('#piutang').hide();
        } else if(type == 2){
            $('#piutang').show();
            $('#other').hide();
        } else {
            $('#other').hide();
            $('#piutang').hide();
        }
    });
</script>