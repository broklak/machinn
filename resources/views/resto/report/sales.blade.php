@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.salesReport')</a> </div>
        <h1>@lang('module.salesReport')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">@lang('web.chooseDateRange')</label>
                <div class="controls">
                    <form>
                        <select onchange="this.form.submit()" name="delivery_type">
                            <option @if($delivery_type == 0) selected @endif value="0">@lang('web.allType')</option>
                            <option @if($delivery_type == 1) selected @endif value="1">@lang('web.deliveryTypeDine')</option>
                            <option @if($delivery_type == 2) selected @endif value="2">@lang('web.deliveryTypeRoom')</option>
                        </select>
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
                        <input type="submit" style="vertical-align: top" value="@lang('web.search')" class="btn btn-primary">
                    </form>
                </div>
                <div style="float: right">
                    <a href="{{route('back.excel.salespos')}}?month={{$numericMonth}}&year={{$year}}" class="btn btn-success">@lang('web.exportCsv')</a>
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
                                <th>@lang('web.billNumber')</th>
                                <th>@lang('web.date')</th>
                                <th>@lang('web.guest')</th>
                                <th>@lang('web.amount')</th>
                                <th>@lang('web.tax')</th>
                                <th>@lang('web.service')</th>
                                <th>@lang('web.discount')</th>
                                <th>Grand Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @php $billed = 0 @endphp
                                @php $tax = 0 @endphp
                                @php $discount = 0 @endphp
                                @php $service = 0 @endphp
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->bill_number}}</td>
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{($val->guest_id == 0) ? 'Non Guest' : \App\Guest::getFullName($val->guest_id)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_billed)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_tax)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_service)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->total_discount)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->grand_total)}}</td>
                                    </tr>
                                    @php $billed = $billed + $val->total_billed @endphp
                                    @php $tax = $tax + $val->total_tax @endphp
                                    @php $service = $service + $val->total_service @endphp
                                    @php $discount = $discount + $val->total_discount @endphp
                                @endforeach
                                <tr>
                                    <td colspan="8" style="text-align: right;font-size: 14px" class="summary-td">{{strtoupper(__('web.totalMenu'))}} : {{\App\Helpers\GlobalHelper::moneyFormatReport($billed)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;font-size: 14px" class="summary-td">{{strtoupper(__('web.totalTax'))}} : {{\App\Helpers\GlobalHelper::moneyFormatReport($tax)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;font-size: 14px" class="summary-td">{{strtoupper(__('web.totalService'))}} : {{\App\Helpers\GlobalHelper::moneyFormatReport($service)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;font-size: 14px" class="summary-td">{{strtoupper(__('web.totalDiscount'))}} : {{\App\Helpers\GlobalHelper::moneyFormatReport($discount)}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="8" style="text-align: center">@lang('msg.noData')</td>
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
