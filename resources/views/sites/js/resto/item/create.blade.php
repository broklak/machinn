<script type="text/javascript">
    function formatMoney(elem) {
        var n = parseInt(elem.val().replace(/\D/g,''),10);
        if(isNaN(n)){
            elem.val('0');
        } else {
            elem.val(n.toLocaleString());
        }
    }

    function getPriceBeforeTax(elem){
        var n = parseInt(elem.val().replace(/\D/g,''),10);
        var tax = $('#tax-gov').val();
        var cost_before_tax = (n * (100 - tax)) / 100;

        if(isNaN(n)){
            elem.val('0');
            $('#cost_before_tax').val('0');
        } else {
            elem.val(n.toLocaleString());
            $('#cost_before_tax').val(cost_before_tax.toLocaleString());
        }
    }
</script>