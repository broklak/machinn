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
</script>