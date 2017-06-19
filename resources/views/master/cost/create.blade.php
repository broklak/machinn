@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('web.cost')</a> <a href="#" class="current">@lang('web.add') @lang('web.cost')</a> </div>
        <h1>@lang('web.cost')</h1>
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
                        <h5>@lang('web.addButton') @lang('web.cost')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.costName')</label>
                                    <div class="controls">
                                        <input value="{{old('cost_name')}}" id="name" required type="text" name="cost_name" />
                                    </div>
                                </div>
                            </div>
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.costAmount')</label>
                                    <div class="controls">
                                        <input value="{{empty(old('cost_amount')) ? 0 : old('cost_amount')}}" type="number" name="cost_amount">
                                    </div>
                                </div>
                            </div>
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.costType')</label>
                                    <div class="controls">
                                        <select name="cost_type">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($type as $key => $val)
                                                <option @if(old('cost_type') == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
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
