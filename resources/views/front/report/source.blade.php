@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Business Source {{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Choose Report Time</label>
                <div class="controls">
                    <form>
                        <select name="month">
                            @foreach($month_list as $key => $val)
                                <option @if($month == $val) selected @endif value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                        <select name="year">
                            @for($x=0; $x < $year_list; $x++)
                                <option @if($year == $year-$x) selected @endif>{{$year - $x}}</option>
                            @endfor
                        </select>
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{$month}} {{$year}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <h5></h5>
                    </div>
                    <div class="widget-content">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>NAME</td>
                                    <td>TOTAL BILL</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows) > 0)
                                    @php $total_all = 0 @endphp
                                    @foreach($rows as $val)
                                        <tr class="odd gradeX">
                                            <td>{{$val->partner_name}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->total_bills)}}</td>
                                        </tr>
                                        @php $total_all = $total_all + $val->total_bills @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="grand_total">TOTAL {{\App\Helpers\GlobalHelper::moneyFormat($total_all)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2" style="text-align: center">No Data Found</td>
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