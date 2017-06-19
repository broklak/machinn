@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.lostAsset')</a> <a href="#" class="current">@lang('web.add') @lang('module.lostAsset')</a> </div>
        <h1>@lang('module.lostAsset')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
            {{csrf_field()}}
        <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>@lang('web.add') @lang('module.lostAsset')</h5>
                        </div>
                        <div class="widget-content nopadding">
                                <div id="form-wizard-1" class="step">
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.add')</label>
                                        <div class="controls">
                                            <input id="date" required class="datepicker" value="{{old('date')}}" data-date-format="yyyy-mm-dd" type="text" name="date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.assetName')</label>
                                        <div class="controls">
                                            <input id="asset_name" required type="text" value="{{old('asset_name')}}" name="asset_name" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('module.roomNumber')</label>
                                        <div class="controls">
                                            <input list="room_numbers" name="room_number_id">
                                            <datalist id="room_numbers">
                                                @foreach($room as $key => $val)
                                                    <option value="{{$val->room_number_code}}"></option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.desc')</label>
                                        <div class="controls">
                                            <textarea id="desc" name="description">{{old('description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('web.reportedBy')</label>
                                        <div class="controls">
                                            <select name="founder_employee_id">
                                                <option>@lang('web.choose')</option>
                                                @foreach($employee as $key => $val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            <input type="hidden" name="lost" value="1">
            <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="@lang('web.save')">
        </div>
        </form>
    </div>

@endsection
