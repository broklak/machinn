<script src="{{ asset("js") }}/jquery.min.js"></script>
<script src="{{ asset("js") }}/jquery-ui.js"></script>
<script src="{{ asset("js") }}/bootstrap.min.js"></script>
<script src="{{ asset("js") }}/matrix.js?v=0.2"></script>

<script src="{{ asset("js") }}/jquery.peity.min.js"></script>
<script src="{{ asset("js") }}/jquery.gritter.min.js"></script>

<script>
    $(document).ready(function(){
        $.ajax({
            type : "GET",
            url  : '{{route('ajax.getLogbook')}}',
            success : function (result) {
                obj = JSON.parse(result);

                $.each(obj, function(key, value) {
                    $.gritter.add({
                        title:	value.title,
                        text:	value.text,
                        sticky: true
                    });
                });
            }
        });
    });
</script>x`

@includeIf($js_name)