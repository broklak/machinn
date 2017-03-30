<script>
    $('#checkin').datepicker({
        dateFormat : 'yy-mm-dd',
        minDate: 0,
        onSelect: function(dateStr) {
            var date = $(this).datepicker('getDate');
            var dateMax = $(this).datepicker('getDate');
            if (date) {
                date.setDate(date.getDate() + 1);
                dateMax.setDate(date.getDate() + 30);
            }
            $('#checkout').datepicker('option', 'maxDate', dateMax);
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

            var checkin = $('#checkin').val();
            var checkout = $('#checkout').val();
        }
    });
</script>