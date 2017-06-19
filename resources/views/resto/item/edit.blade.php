@extends('layout.main')

@section('title', 'Home')

@section('content')

<div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.itemPrice')</a> <a href="#" class="current">@lang('web.edit') @lang('module.itemPrice')</a> </div>
    <h1>@lang('module.itemPrice')</h1>
</div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.edit') @lang('module.itemPrice')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.outletType')</label>
                                    <div class="controls">
                                        <select name="fnb">
                                            <option @if($row->fnb_type == 0) selected @endif value="0">@lang('web.choose')</option>
                                            <option @if($row->fnb_type == 1) selected @endif value="1">@lang('web.roomService')</option>
                                            <option @if($row->fnb_type == 2) selected @endif value="2">@lang('web.outletResto')</option>
                                            <option @if($row->fnb_type == 3) selected @endif value="3">@lang('web.outletBanquet')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('module.itemCategory')</label>
                                    <div class="controls">
                                        <select name="category_id">
                                            <option disabled @if($row->category_id == 0) selected @endif value="0">@lang('web.choose')</option>
                                            @foreach($category as $key => $val)
                                                <option @if($row->category_id == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.name')</label>
                                    <div class="controls">
                                        <input id="name" value="{{$row->name}}" required type="text" name="name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.basicCost')</label>
                                    <div class="controls">
                                        <input onkeyup="formatMoney($(this))" id="cost_basic" value="{{\App\Helpers\GlobalHelper::moneyFormatReport($row->cost_basic)}}" required type="text" name="cost_basic" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.priceNoTax')</label>
                                    <div class="controls">
                                        <input id="cost_before_tax" value="{{\App\Helpers\GlobalHelper::moneyFormatReport($row->cost_before_tax)}}" readonly type="text" name="cost_before_tax" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.priceSales')</label>
                                    <div class="controls">
                                        <input onkeyup="getPriceBeforeTax($(this))" id="cost_sales" value="{{\App\Helpers\GlobalHelper::moneyFormatReport($row->cost_sales)}}" required type="text" name="cost_sales" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.tax')</label>
                                    <div style="vertical-align: bottom" class="controls">
                                        @foreach($tax as $key => $val)
                                            <span style="margin-right: 10px;font-size: 12px;vertical-align: sub">{{$val->name}} ({{$val->percentage}}%)</span>
                                            @if($val->id == 1)
                                                <input type="hidden" id="tax-gov" value="{{$val->percentage}}">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                            {{method_field("PUT")}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
