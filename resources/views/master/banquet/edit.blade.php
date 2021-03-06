@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.banquetTime')</a> <a href="#" class="current">@lang('web.edit') @lang('module.banquetTime')</a> </div>
        <h1>@lang('module.banquetTime')</h1>
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
                        <h5>@lang('web.edit') @lang('module.banquetTime')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->banquet_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.banquetName')</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->banquet_name}}" name="banquet_name" />
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('master.banquetStart')</label>
                                        <div class="controls">
                                            <input style="width: 30em" required value="{{$row->banquet_start}}"  type="text" name="banquet_start" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">@lang('master.banquetEnd')</label>
                                        <div class="controls">
                                            <input style="width: 30em" required type="text" value="{{$row->banquet_end}}"  name="banquet_end" />
                                        </div>
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
