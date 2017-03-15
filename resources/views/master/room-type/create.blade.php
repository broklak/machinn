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
                                    <label class="control-label">{{$master_module}} Name</label>
                                    <div class="controls">
                                        <input value="{{old('room_type_name')}}" id="name" required type="text" name="room_type_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Group</label>
                                    <div class="controls">
                                        <select multiple name="room_type_attributes[]">
                                            <option disabled selected>Choose more than one attribute</option>
                                            @foreach($attribute as $key => $val)
                                                <option value="{{$val['room_attribute_id']}}">{{$val['room_attribute_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Weekday Price</label>
                                    <div class="controls">
                                        <input value="{{empty(old('day_type_1')) ? 0 : old('day_type_1')}}" id="day_type_1" required type="number" name="day_type_1" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Weekend Price</label>
                                    <div class="controls">
                                        <input value="{{empty(old('day_type_2')) ? 0 : old('day_type_2')}}" id="day_type_2" required type="number" name="day_type_2" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Max Adult</label>
                                    <div class="controls">
                                        <input value="{{empty(old('room_type_max_adult')) ? 2 : old('room_type_max_adult')}}" id="room_type_max_adult" required type="number" name="room_type_max_adult" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Max Child</label>
                                    <div class="controls">
                                        <input value="{{empty(old('room_type_max_child')) ? 2 : old('room_type_max_child')}}" id="room_type_max_child" required type="number" name="room_type_max_child" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Banquet</label>
                                    <div class="controls">
                                        <input type="radio" value="1" name="room_type_banquet" id="yes"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes">Yes</label>
                                        <input type="radio" value="0" checked name="room_type_banquet" id="no"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no">No</label>
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