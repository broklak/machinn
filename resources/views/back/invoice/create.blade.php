@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.invoice')</a> <a href="#" class="current">@lang('web.add') @lang('module.invoice')</a> </div>
        <h1>@lang('module.invoice')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="{{route('invoice.index')}}">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.addButton') Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.invoiceDate')</label>
                                    <div class="controls">
                                        <input id="date" required type="text" name="invoice_date" data-date-format="yyyy-mm-dd" class="datepicker" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.dueDate')</label>
                                    <div class="controls">
                                        <input id="due_date" required type="text" name="due_date" data-date-format="yyyy-mm-dd" class="datepicker" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.amount')</label>
                                    <div class="controls">
                                        <input id="amount" required type="number" name="amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.description')</label>
                                    <div class="controls">
                                        <input id="description" type="text" name="description" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.partner')</label>
                                    <div class="controls">
                                        <select name="source_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($partner as $key => $val)
                                                <option @if(old('source_id') == $val['partner_id']) selected="selected" @endif value="{{$val['partner_id']}}">{{$val['partner_name']}}</option>
                                            @endforeach
                                        </select>
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
                                    <label class="control-label">@lang('web.cost')</label>
                                    <div class="controls">
                                        <select name="cost_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cost as $key => $val)
                                                <option @if(old('cost_id') == $val['cost_id']) selected="selected" @endif value="{{$val['cost_id']}}">{{$val['cost_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
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
