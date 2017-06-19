<script src="{{ asset("js") }}/bootstrap-datepicker.js"></script>
<script>
    $('.datepicker').datepicker();

    $('.chooseGuest').click(function(){
        searchGuest($(this));
    });

    $('#searchGuestForm').submit(function(){
        var filter = $('#searchguest').val();
        var listGuest = [];
        $.ajax({
            type  : "POST",
            data    : $(this).serialize(),
            url     : "{{route('ajax.searchGuest')}}",
            success : function(result){
                $('#listGuest').html("");
                obj = JSON.parse(result);
                i = 0;
                $.each(obj, function(key, value) {
                    i++;
                    rowType = (i % 2 == 1) ? 'odd' : 'even';
                    listGuest.push('<tr class="'+rowType+' gradeX">');
                    listGuest.push('<td>'+value.first_name+' '+value.last_name+'</td>');
                    listGuest.push('<td>'+value.id_number+' ('+getIDTypeName(value.id_type)+')</td>');
                    listGuest.push('<td><a data-dismiss="modal" data-firstname="'+value.first_name+'" data-lastname="'+value.last_name+'"');
                    listGuest.push('data-idtype="'+value.id_type+'" data-idnumber="'+value.id_number+'" data-email="'+value.email+'" data-guesttype="'+value.type+'"');
                    listGuest.push('data-birthdate="'+value.birthdate+'" data-religion="'+value.religion+'" data-gender="'+value.gender+'" data-job="'+value.job+'"');
                    listGuest.push('data-birthplace="'+value.birthplace+'" data-address="'+value.address+'" data-countryid="'+value.country_id+'" data-id="'+value.guest_id+'"');
                    listGuest.push('data-provinceid="'+value.province_id+'" data-zipcode="'+value.zipcode+'" data-homephone="'+value.homephone+'" data-guesttitle="'+value.title+'"');
                    listGuest.push('data-handphone="'+value.handphone+'" class="btn btn-success chooseGuest">@lang('web.choose')</a></td>')
                    listGuest.push('</tr>');
                });
                listElement = listGuest.join(" ");
                $('#listGuest').html(listElement);

                $('.chooseGuest').click(function(){
                    searchGuest($(this));
                });
            }
        });

        return false;
    });


    function searchGuest (elem) {
        var id = elem.data("id");
        var first_name = elem.data("firstname");
        var last_name = elem.data("lastname");
        var email = elem.data("email");
        var address = elem.data("address");
        var handphone = elem.data("handphone");

        $('#report_name').val(first_name + ' ' + last_name);
        $('#report_address').html(address);
        $('#phone').val(handphone);
        $('#email').val(email);
        $('#guest_id').val(id);
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
