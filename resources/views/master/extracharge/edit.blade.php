@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.extracharge')</a> <a href="#" class="current">@lang('web.edit') @lang('module.extracharge')</a> </div>
        <h1>@lang('module.extracharge')</h1>
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
                        <h5>@lang('web.addButton') @lang('module.extracharge')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->extracharge_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.name')</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->extracharge_name}}" name="extracharge_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.price')</label>
                                    <div class="controls">
                                        <input id="price" required type="text" value="{{$row->extracharge_price}}" name="extracharge_price" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('master.extraGroup')</label>
                                    <div class="controls">
                                        <select name="extracharge_group_id">
                                            @foreach($group as $key => $val)
                                                <option @if($row->extracharge_group_id == $val['extracharge_group_id']) selected="selected" @endif value="{{$val['extracharge_group_id']}}">{{$val['extracharge_group_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.category')</label>
                                    <div class="controls">
                                        <select name="extracharge_type">
                                            @foreach($type as $key => $val)
                                                <option @if($row->extracharge_type == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
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
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
