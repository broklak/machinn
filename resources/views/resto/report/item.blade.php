@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Item {{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <form>
                <label class="control-label">Choose Report Time</label>
                <div class="controls">
                        <select name="month">
                            @foreach($month_list as $key => $val)
                                <option @if($month == $val) selected @endif value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                        <select name="year">
                            @for($x=0; $x < $year_list; $x++)
                                <option @if($year == date('Y')-$x) selected @endif>{{date('Y') - $x}}</option>
                            @endfor
                        </select>
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                </div>
                    <label class="control-label">Sort By</label>
                    <div class="controls">
                        <select onchange="this.form.submit()" name="order">
                            <option @if($order == 1) selected @endif value="1">Name (A - Z)</option>
                            <option @if($order == 2) selected @endif value="2">Name (Z - A)</option>
                            <option @if($order == 3) selected @endif value="3">Sales (Low - High)</option>
                            <option @if($order == 4) selected @endif value="4">Sales (High - Low)</option>
                        </select>
                    </div>
                </form>
                <div style="float: right">
                    <a href="{{route('back.excel.itempos')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">Export to CSV</a>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{$month}} {{$year}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Cost Basic</th>
                                <th>Net Price</th>
                                <th>Stock</th>
                                <th>Total Sold Qty</th>
                                <th>Total Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->name}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->cost_basic)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->cost_sales)}}</td>
                                        <td>{{$val->stock}}</td>
                                        <td>{{$val->total_qty}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_sales)}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" style="text-align: center">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection