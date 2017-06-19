<script type="text/javascript">
    function formatStock(elem) {
        elem.val('');
    }

    function changeStock(elem){
        var id = elem.data('id');
        var name = elem.data('name');
        var newStock = $('#stock-'+id).val();

        $.ajax({
            type  : "GET",
            data    : {"id":id, "stock":newStock},
            url     : "{{route('ajax.changeStock')}}",
            success : function () {
                alert('@lang('msg.successChangeStock') '+name);
            }
        });
    }

    function setOutOfStock(elem){
        var id = elem.data('id');
        var name = elem.data('name');

        $.ajax({
            type  : "GET",
            data    : {"id":id},
            url     : "{{route('ajax.setOutStock')}}",
            success : function () {
                alert('@lang('msg.successChangeStock') '+name);
                $('#stock-'+id).val('0');
            }
        });
    }

</script>
