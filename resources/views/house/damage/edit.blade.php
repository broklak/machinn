@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Create {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
            {{csrf_field()}}
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Item Information</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">Date</label>
                                    <div class="controls">
                                        <input id="date" required class="datepicker" value="{{$row->date}}" data-date-format="yyyy-mm-dd" type="text" name="date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Asset Name</label>
                                    <div class="controls">
                                        <input id="asset_name" required type="text" value="{{$row->asset_name}}" name="asset_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Room Number</label>
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
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea id="desc" name="description">{{$row->description}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Reported By</label>
                                    <div class="controls">
                                        <select name="founder_employee_id">
                                            <option>Choose Employee</option>
                                            @foreach($employee as $key => $val)
                                                <option @if($row->founder_employee_id == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ method_field('PUT') }}
                </div>
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE">
            </div>
        </form>
    </div>

@endsection