@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}} by Check In</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Choose Date Range</label>
                <div class="controls">
                    <form>
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
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
                                    <th>NOMOR</th>
                                    <th>DATE</th>
                                    <th>ADULT GUEST</th>
                                    <th>CHILD GUEST</th>
                                    <th>TOTAL GUEST</th>
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
                                        <td colspan="3" style="text-align: center">No Data Found</td>
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