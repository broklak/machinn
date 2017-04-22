@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Edit {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Edit {{$master_module}} Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->logbook_id])}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="grant_type" value="{{$type}}">
                            <div id="form-wizard-1" class="step">
                                <div id="form-wizard-1" class="step">
                                    <div class="control-group">
                                        <label class="control-label">Message</label>
                                        <div class="controls">
                                            <textarea name="logbook_message">{{$row->logbook_message}}</textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">To Department</label>
                                        <div class="controls">
                                            <select name="to_dept_id">
                                                <option disabled selected>Choose Department</option>
                                                @foreach($dept as $key => $val)
                                                    <option @if($row->to_dept_id == $val['department_id']) selected="selected" @endif value="{{$val['department_id']}}">{{$val['department_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Reminder Date</label>
                                        <div class="controls">
                                            <input type="text" value="{{$row->to_date}}" class="datepicker" data-date-format="yyyy-mm-dd" name="to_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="Save" />
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