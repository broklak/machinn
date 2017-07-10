<script type="text/javascript">
    $(function(){
        $('#checkin').datepicker({
            dateFormat : 'yy-mm-dd',
            onSelect: function(dateStr) {
                var date = $(this).datepicker('getDate');
                if (date) {
                    date.setDate(date.getDate() + 1);
                }
                $('#checkout').datepicker('option', 'minDate', date);
            }
        });

        $('#checkout').datepicker({
            dateFormat : 'yy-mm-dd',
            onSelect: function (selectedDate) {
                var date = $(this).datepicker('getDate');
                if (date) {
                    date.setDate(date.getDate() - 1);
                }
                $('#checkin').datepicker('option', 'maxDate', date || 0);
            }
        });
    });

    function  addTotal(thiz){

      var total = parseInt($(thiz).data('total'));
      var total_audit = parseInt($('#total_audit').val());

      if($(thiz).prop('checked')) {
        var total_all = total_audit + total;
      } else {
        var total_all = total_audit - total;
      }

      $('#total_audit').val(total_all);
      $('#total_audit_text').html(toMoney(total_all));
    }

    function toMoney(num) {
        return 'IDR '+num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
</script>
