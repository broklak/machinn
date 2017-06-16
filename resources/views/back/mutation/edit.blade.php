@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.mutation')</a> <a href="#" class="current">@lang('web.edit') @lang('module.mutation')</a> </div>
        <h1>@lang('module.mutation')</h1>
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
                        <h5>@lang('web.edit') @lang('module.mutation')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.date')</label>
                                    <div class="controls">
                                        <input id="date" value="{{$row->date}}" required type="text" name="date" data-date-format="yyyy-mm-dd" class="datepicker" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.accountSender')</label>
                                    <div class="controls">
                                        <select name="from">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cash_account as $key => $val)
                                                <option @if($row->from == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.accountReceiver')</label>
                                    <div class="controls">
                                        <select name="to">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cash_account as $key => $val)
                                                <option @if($row->to == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.amount')</label>
                                    <div class="controls">
                                        <input id="amount" value="{{$row->amount}}" required type="number" name="amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.description')</label>
                                    <div class="controls">
                                        <input id="description" value="{{$row->desc}}" type="text" name="description" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
