@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.transaction' : 'transaction'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.expense')</a> <a href="#" class="current">@lang('web.add') @lang('module.expense')</a> </div>
        <h1>@lang('module.expense')</h1>
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
                        <h5>@lang('web.add') @lang('module.expense')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.date')</label>
                                    <div class="controls">
                                        <input value="{{old('date')}}" id="date" required type="text" name="date" class="datepicker" data-date-format="yyyy-mm-dd" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.costType')</label>
                                    <div class="controls">
                                        <select id="cost_id" name="cost_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cost as $key => $val)
                                                <option @if(old('cost_id') == $val['cost_id']) selected="selected" @endif value="{{$val['cost_id']}}">{{$val['cost_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @foreach($cost as $key => $val)
                                        <input type="hidden" id="cost_amount_{{$val['cost_id']}}" value="{{$val['cost_amount']}}" />
                                    @endforeach
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.amount')</label>
                                    <div class="controls">
                                        <input value="{{old('amount')}}" id="amount" required type="number" name="amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.desc')</label>
                                    <div class="controls">
                                        <input value="{{old('desc')}}" id="desc" required type="text" name="desc" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.department')</label>
                                    <div class="controls">
                                        <select name="department_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($department as $key => $val)
                                                <option @if(old('department_id') == $val['department_id']) selected="selected" @endif value="{{$val['department_id']}}">{{$val['department_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.source')</label>
                                    <div class="controls">
                                        <select name="cash_account_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cash as $key => $val)
                                                <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.saveForm')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
