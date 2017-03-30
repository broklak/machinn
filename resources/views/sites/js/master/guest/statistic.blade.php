@if(count($rows) > 0)
    <script src="{{asset('js')}}/jquery.flot.min.js"></script>
    <script src="{{asset('js')}}/jquery.flot.pie.min.js"></script>
    <script src="{{asset('js')}}/matrix.charts.js?v=1.1"></script>
    <script src="{{asset('js')}}/jquery.flot.resize.min.js"></script>
    <script src="{{asset('js')}}/jquery.peity.min.js"></script>
@endif

<script type="text/javascript">
    $(function(){

        @if(count($rows) > 0)
            var data = {!! $rows !!};
            var series = "{{count($rows)}}";
            i = -1;
            var pie = $.plot($(".pie"), data,{
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 3/4,
                            formatter: function(label, series){
                                i++;
                                console.log(data);
                                return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+' ('+data[i].data+')<br/>'+Math.round(series.percent)+'%</div>';
                            },
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        },
                        innerRadius: 0.3
                    },
                    legend: {
                        show: false
                    }
                }
            });
        @endif

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