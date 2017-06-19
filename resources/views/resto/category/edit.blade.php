@extends('layout.main')

@section('title', 'Home')

@section('content')

<div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.itemCategory')</a> <a href="#" class="current">@lang('web.edit') @lang('module.itemCategory')</a> </div>
    <h1>@lang('module.itemCategory')</h1>
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
                        <h5>@lang('web.edit') @lang('module.itemCategory')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.name')</label>
                                    <div class="controls">
                                        <input id="name" value="{{$row->name}}" required type="text" name="name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.desc')</label>
                                    <div class="controls">
                                        <textarea name="desc">{{$row->desc}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.type')</label>
                                    <div class="controls">
                                        <input @if($row->type == 1) checked @endif type="radio" value="1" name="type" id="food"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="food">@lang('web.menuTypeFood')</label>
                                        <input @if($row->type == 2) checked @endif type="radio" value="2" name="type" id="beve"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="beve">@lang('web.menuTypeBeverage')</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.menuTypeBeverage') (%)</label>
                                    <div class="controls">
                                        <input id="percentage" value="{{$row->discount}}" type="text" name="discount" />
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
