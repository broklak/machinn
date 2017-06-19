@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.guestByCheckin')</a> </div>
        <h1>@lang('module.guestByCheckin')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">@lang('web.chooseDateRange')</label>
                <div class="controls">
                    <form>
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" value="@lang('web.search')" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{strtoupper(__('web.date'))}}</th>
                                    <th>{{strtoupper(__('web.adult'))}}</th>
                                    <th>{{strtoupper(__('web.child'))}}</th>
                                    <th>TOTAL {{strtoupper(__('web.guest'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($rows) > 0)
                                    @php $x = 0; $total_adult=0; $total_child=0; $total_guest=0; @endphp
                                    @foreach($rows as $val)
                                        @php $x++; @endphp
                                        <tr class="odd gradeX">
                                            <td>{{$x}}</td>
                                            <td>{{date('j F Y', strtotime($val->checkin_date))}}</td>
                                            <td>{{$val->adult_num}}</td>
                                            <td>{{$val->child_num}}</td>
                                            <td>{{$val->total}}</td>
                                        </tr>
                                        @php $total_adult += $val->adult_num; $total_child += $val->child_num; $total_guest += $val->total; @endphp
                                    @endforeach
                                        <tr>
                                            <td class="summary-td" style="text-align: right" colspan="2">TOTAL</td>
                                            <td class="summary-td">{{$total_adult}}</td>
                                            <td class="summary-td">{{$total_child}}</td>
                                            <td class="summary-td">{{$total_guest}}</td>
                                        </tr>
                                @else
                                    <tr>
                                        <td colspan="3" style="text-align: center">@lang('msg.noData')</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
