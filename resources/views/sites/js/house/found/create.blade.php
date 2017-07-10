<script src="{{ asset("js") }}/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker();

    $('.chooseEmployee').click(function(){
        searchEmployee($(this));
    });

    $('input[type=radio][name=type]').change(function() { // IS BANQUET
      if (this.value == '1') {
        $('#yes-lost').show();
      } else {
        $('#yes-lost').hide();
      }
    });

    $('#lost_id').change(function () {
        var val = $(this).val();
        var itemname = $('#opt-'+val).data('itemname');
        var itemvalue = $('#opt-'+val).data('itemvalue');
        var itemcolor = $('#opt-'+val).data('itemcolor');
        var itemplace = $('#opt-'+val).data('itemplace');
        var itemdesc = $('#opt-'+val).data('itemdesc');
        $('#item_name').val(itemname);
        $('#item_color').val(itemcolor);
        $('#item_value').val(itemvalue);
        $('#place').val(itemplace);
        $('#desc').html(itemdesc);
    });

    $('#searchEmployeeForm').submit(function(){
        var filter = $('#searchemployee').val();
        var listEmployee = [];
        $.ajax({
            type  : "POST",
            data    : $(this).serialize(),
            url     : "{{route('ajax.searchEmployee')}}",
            success : function(result){
                $('#listEmployee').html("");
                obj = JSON.parse(result);
                i = 0;
                $.each(obj, function(key, value) {
                    i++;
                    rowType = (i % 2 == 1) ? 'odd' : 'even';
                    listEmployee.push('<tr class="'+rowType+' gradeX">');
                    listEmployee.push('<td>'+value.username+'</td>');
                    listEmployee.push('<td>'+value.department+'</td>');
                    listEmployee.push('<td><a data-dismiss="modal" data-name="'+value.username+'" data-id="'+value.id+'"');
                    listEmployee.push('class="btn btn-success chooseEmployee">@lang('web.choose')</a></td>')
                    listEmployee.push('</tr>');
                });
                listElement = listEmployee.join(" ");
                $('#listEmployee').html(listElement);

                $('.chooseEmployee').click(function(){
                    searchEmployee($(this));
                });
            }
        });

        return false;
    });


    function searchEmployee (elem) {
        var id = elem.data("id");
        var name = elem.data("name");

        $('#founder_name').val(name);
        $('#employee_id').val(id);
    }


    function getIDTypeName (type){
        if(type == 1){
            return 'KTP';
        } else if(type == 2) {
            return 'SIM';
        } else {
            return 'PASSPORT';
        }
    }
</script>
