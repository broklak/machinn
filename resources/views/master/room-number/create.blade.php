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
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Add New {{$master_module}}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}}</label>
                                    <div class="controls">
                                        <input value="{{old('room_number_code')}}" id="name" required type="text" name="room_number_code" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Room Type</label>
                                    <div class="controls">
                                        <select name="room_type_id">
                                            <option disabled selected>Choose {{$master_module}} Type</option>
                                            @foreach($type as $key => $val)
                                                <option @if(old('room_type_id') == $val['room_type_id']) selected="selected" @endif value="{{$val['room_type_id']}}">{{$val['room_type_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Room Floor</label>
                                    <div class="controls">
                                        <select name="room_floor_id">
                                            <option disabled selected>Choose {{$master_module}} Floor</option>
                                            @foreach($floor as $key => $val)
                                                <option @if(old('room_floor_id') == $val['property_floor_id']) selected="selected" @endif value="{{$val['property_floor_id']}}">{{$val['property_floor_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="Save" />
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