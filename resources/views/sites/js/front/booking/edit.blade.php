<script>
    $(function() {
        $( document ).ready(function() {
            var checkin = $('#checkin').val();
            var checkout = $('#checkout').val();

            getAvailableRoom(checkin, checkout);
        });

        $('.removeRoom').click(function(e){
            removeRoom($(this));
            e.preventDefault();
        });

        $('#checkin').datepicker({
            dateFormat : 'yy-mm-dd',
            minDate: 0,
            onSelect: function(dateStr) {
                resetRoom();
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
                resetRoom();
                var date = $(this).datepicker('getDate');
                if (date) {
                    date.setDate(date.getDate() - 1);
                }
                $('#checkin').datepicker('option', 'maxDate', date || 0);

                var checkin = $('#checkin').val();
                var checkout = $('#checkout').val();

                getAvailableRoom(checkin, checkout);
            }
        });
        $('#birthdate').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: 0,
            yearRange: "-70:+0",
        });

        $('#card_expired_date').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm yy',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });

        $('#createGuestButton').click(function(){
            $('#first_name').focus();
            $('#guest_id').val('');
            $('#first_name').val('');
            $('#last_name').val('');
            $('#mr').prop('checked', false);
            $('#mrs').prop('checked', false);
            $('#miss').prop('checked', false);
            $('#reg').prop('checked', false);
            $('#vip').prop('checked', false);
            $('#id_type').val('0');
            $('#id_number').val('');
            $('#email').val('');
            $('#homephone').val('');
            $('#handphone').val('');
            $('#birthplace').val('');
            $('#birthdate').val('');
            $('#male').prop('checked', false);
            $('#female').prop('checked', false);
            $('#religion').val('0');
            $('#job').val('');
            $('#address').val('');
            $('#country_id').val('0');
            $('#provinceContainer').show();
        });

        $('input[type=radio][name=type]').change(function() { // GUARANTEDD OR TENTATIVE BOOKING
            if (this.value == '1') {
                $('#need_dp').val('1');
                $('#dp-container').show();
            }
            else if (this.value == '2') {
                $('#need_dp').val('0');
                $('#dp-container').hide();
            }
        });


        function searchGuest (elem) {
            var id = elem.data("id");
            var first_name = elem.data("firstname");
            var last_name = elem.data("lastname");
            var id_type = elem.data("idtype");
            var id_number = elem.data("idnumber");
            var email = elem.data("email");
            var religion = elem.data("religion");
            var gender = elem.data("gender");
            var job = elem.data("job");
            var address = elem.data("address");
            var country_id = elem.data("countryid");
            var province_id = elem.data("provinceid");
            var zipcode = elem.data("zipcode");
            var homephone = elem.data("homephone");
            var handphone = elem.data("handphone");
            var birthdate = elem.data("birthdate");
            var birthplace = elem.data("birthplace");
            var guesttype = elem.data("guesttype");
            var guesttitle = elem.data("guesttitle");

            $('#first_name').val(first_name);
            $('#last_name').val(last_name);
            $('#id_number').val(id_number);
            $('#email').val(email);
            $('#homephone').val(homephone);
            $('#handphone').val(handphone);
            $('#birthplace').val(birthplace);
            $('#birthdate').val(birthdate);
            $('#job').val(job);
            $('#address').val(address);
            $('#id_type').val(id_type);
            $('#guest_id').val(id);

            if(gender == 1){
                $('#male').prop('checked', true);
            } else {
                $('#female').prop('checked', true);
            }

            if(guesttype == 1){
                $('#reg').prop('checked', true);
            } else {
                $('#vip').prop('checked', true);
            }

            if(guesttitle == 1){
                $('#mr').prop('checked', true);
            } else if(guesttitle == 2) {
                $('#mrs').prop('checked', true);
            } else {
                $('#mis').prop('checked', true);
            }

            $('#religion').val(religion);

            $('#country_id').val(country_id);

            $('#provinceContainer').hide();

        };

        $('.chooseGuest').click(function(){
            searchGuest($(this));
        });

        $('#country_id').change(function(){
            var country = $(this).val();

            $.ajax({
                type        : "GET",
                data        : {"country":country},
                url         : "{{route('ajax.searchProvince')}}",
                success     : function (result){
                    $('#province_id').html("");
                    obj = JSON.parse(result);
                    $('#province_id').append('<option disabled selected>Choose Province</option>');
                    $.each(obj, function(key, value) {
                        $('#province_id').append('<option value="'+value.province_id+'">'+value.province_name+'</option>');
                    });
                }
            });
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
                        listGuest.push('data-handphone="'+value.handphone+'" class="btn btn-success chooseGuest">Choose</a></td>')
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

        $('#searchRoomForm').submit(function(){
            var checkin = $('#checkin').val();
            var checkout = $('#checkout').val();
            var type = $('#room_type_filter').val();
            var floor = $('#floor_filter').val();

            getAvailableRoom(checkin, checkout, type, floor);

            return false;
        });

    });

    function getIDTypeName (type){
        if(type == 1){
            return 'KTP';
        } else if(type == 2) {
            return 'SIM';
        } else {
            return 'PASSPORT';
        }
    }

    $('#payment_method').change(function(){
        var payment = $(this).val();

        if(payment == 1 || payment == 2){
            $('#cc-container').hide();
            $('#bt-container').hide();
        } else{
            if(payment == 3){
                $('#cc-container').show();
                $('#bt-container').hide();
            } else {
                $('#bt-container').show();
                $('#cc-container').hide();
            }
        }
    });

    $('#form-booking').submit(function(){
        $('#error_messages').html("");
        return validateOnSubmit();

    });

    function getAvailableRoom (dateIn, dateOut, type, floor) {
        var listRoom = [];
        $.ajax({
            type     : 'GET',
            data     : {"checkin" : dateIn, "checkout" : dateOut, "type" : type, "floor" : floor},
            url      : "{{route('ajax.searchRoom')}}",
            success  : function(result) {
                $('#listRoom').html("");
                obj = JSON.parse(result);
                i = 0;
                $.each(obj, function(key, value) {
                    listRoom.push('<tr>');
                    listRoom.push('<td>'+value.room_number_code+'</td>');
                    listRoom.push('<td>'+value.room_type_name+'</td>');
                    listRoom.push('<td>'+value.property_floor_name+'</td>');
                    listRoom.push('<td>'+toMoney(value.room_rate_weekdays)+'</td>');
                    listRoom.push('<td>'+toMoney(value.room_rate_weekends)+'</td>');
                    listRoom.push('<td><a data-id="'+value.room_number_id+'" data-weekdays="'+value.room_rate_weekdays+'" data-weekends="'+value.room_rate_weekends+'" data-type="'+value.room_type_id+'" data-code="'+value.room_number_code+'" class="btn btn-success chooseRoom">Choose</a></td>');
                });
                listRoomElement = listRoom.join(" ");
                $('#listRoom').html(listRoomElement);

                $('.chooseRoom').click(function(){
                    chooseRoom($(this));
                });
            }
        });
    }

    function toMoney(num) {
        return 'IDR '+num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }

    function chooseRoom (elem){
        var id = elem.data('id');
        var code = elem.data('code');
        var selectedRoom = $('#room_number').val();
        var roomList = selectedRoom.split(",");
        var rateWeekdays = elem.data('weekdays');
        var rateWeekends = elem.data('weekends');
        var type = elem.data("type");
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();

        if($.inArray(id.toString(), roomList) !== -1){ // ALREADY SELECTED
            alert("Room Number "+code+' is already selected');
        } else { // NOT YET SELECTED
            roomList.push(id);
            joinRoom = roomList.join(',');
            $('#room_number').val(joinRoom);

            // GET TOTAL ROOM RATES
            var action = 'plus';
            getTotalRoomRate(checkin, checkout, rateWeekdays, rateWeekends, type, action);
            $('#selectedRoomContainer').append('<a href="#" title="Click to remove room" class="badge badge-success tip-top removeRoom" data-id="'+id+'" data-code="'+code+'" data-type="'+type+'" data-weekendrate="'+rateWeekends+'" data-weekdayrate="'+rateWeekdays+'" data-original-title="Click to remove room">'+code+'</a> ');
            alert("Room Number "+code+' is selected');

            $('.removeRoom').click(function(e){
                removeRoom($(this));
                e.preventDefault();
            });
        }
    }

    function getTotalRoomRate (checkinDate, checkoutDate, weekdayRate, weekendRate, roomType, action){
        var totalRates = $('#total_rates').val();
        $.ajax({
            type    : 'GET',
            data    : {"type" : roomType, "rateWeekdays" : weekdayRate, "rateWeekends" : weekendRate, "checkin" : checkinDate, "checkout" : checkoutDate, "totalRates" : totalRates, "action" : action},
            url     : "{{route('ajax.getTotalRoomRates')}}",
            success : function(result){
                obj = JSON.parse(result);
                $('#total_rates').val(obj.total_rates);
                $('#booking_rate').val(toMoney(obj.total_rates));
            }
        });
    }

    function removeRoom (elem) {
        var totalRates = $('#total_rates').val();
        var id = elem.data('id');
        var code = elem.data('code');
        var selectedRoom = $('#room_number').val();
        var roomList = selectedRoom.split(",");
        var type = elem.data("type");
        var weekend = elem.data("weekendrate");
        var weekday = elem.data("weekdayrate");
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();
        var index = $.inArray(id.toString(), roomList);

        var action = 'minus';
        getTotalRoomRate(checkin, checkout, weekday, weekend, type, action);

        if (index > -1) {
            roomList.splice(index, 1);
        }
        elem.remove();
        joinRoom = roomList.join(',');
        $('#room_number').val(joinRoom);
    }

    function resetRoom () {
        $('#total_rates').val("");
        $('#booking_rate').val("");
        $('#selectedRoomContainer').html("");
        $('#room_number').val("");
    }

    function validateOnSubmit(){
        var err = 0;
        var type = $('input[type=radio][name=type]:checked').val();
        var room_plan = $('#room_plan_id').val();
        var partner_id = $('#partner_id').val();
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();
        var room = $('#room_number').val();
        var guest = $('#guest_id').val();

        if(type == undefined){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please choose booking type</div>');
        }
        if(room_plan == 0){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please choose room plan</div>');
        }
        if(partner_id == 0){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please choose source</div>');
        }
        if(checkin == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please input checkin date</div>');
        }
        if(checkout == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please input checkout date</div>');
        }
        if(room == ''){
            err = 1;
            $('#error_messages').append('<div class="alert alert-error">Please select room</div>');
        }

        if(guest == ''){
            var title = $('input[type=radio][name=guest_title]:checked').val();
            var first_name = $('#first_name').val();
            var id_type = $('#id_type').val();
            var id_number = $('#id_number').val();
            var handphone = $('#handphone').val();
            var gender = $('input[type=radio][name=gender]:checked').val();
            var country_id = $('#country_id').val();

            if(title == undefined){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please choose guest title name</div>');
            }
            if(first_name == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input guest first name</div>');
            }
            if(id_type == 0){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input guest ID type</div>');
            }
            if(id_number == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input guest ID number</div>');
            }
            if(handphone == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input guest handphone number</div>');
            }
            if(gender == undefined){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input guest gender</div>');
            }
            if(country_id == 0){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please select guest country</div>');
            }
        }

        if(type == 1){
            var payment_method = $('#payment_method').val();
            var down_payment_amount = $('#down_payment_amount').val();

            if(payment_method == 0){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please select payment method</div>');
            }
            if(down_payment_amount == ''){
                err = 1;
                $('#error_messages').append('<div class="alert alert-error">Please input down payment amount</div>');
            }

        }
        if(err == 1){
            $('#error_messages').goTo();
            return false;
        } else {
            return true;
        }
    }

    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 80 + 'px'
        }, 'slow');
        return this; // for chaining...
    }

</script>