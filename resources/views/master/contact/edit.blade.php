@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.contact')</a> <a href="#" class="current">@lang('web.edit') @lang('module.contact')</a> </div>
        <h1>@lang('module.contact')</h1>
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
                        <h5>@lang('web.edit') @lang('module.contact')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->contact_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.contactName')</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->contact_name}}" name="contact_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('master.contactGroup')</label>
                                    <div class="controls">
                                        <select name="contact_group_id">
                                            @foreach($group as $key => $val)
                                                <option @if($row->contact_group_id == $val['contact_group_id']) selected="selected" @endif value="{{$val['contact_group_id']}}">{{$val['contact_group_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.phone')</label>
                                    <div class="controls">
                                        <input value="{{$row->contact_phone}}" id="name" required type="text" name="contact_phone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.address')</label>
                                    <div class="controls">
                                        <textarea name="contact_address">{{$row->contact_address}}</textarea>
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
