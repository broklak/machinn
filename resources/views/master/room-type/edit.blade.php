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
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->room_type_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Name</label>
                                    <div class="controls">
                                        <input value="{{$row->room_type_name}}" id="name" required type="text" name="room_type_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Group</label>
                                    <div class="controls">
                                        <select multiple name="room_type_attributes[]">
                                            <option disabled>Choose more than one attribute</option>
                                            @php $attr = explode(',', $row->room_type_attributes) @endphp
                                            @foreach($attribute as $key => $val)
                                                <option @if(in_array($val['room_attribute_id'], $attr)) selected @endif value="{{$val['room_attribute_id']}}">{{$val['room_attribute_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Max Adult</label>
                                    <div class="controls">
                                        <input value="{{$row->room_type_max_adult}}" id="room_type_max_adult" required type="number" name="room_type_max_adult" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Max Child</label>
                                    <div class="controls">
                                        <input value="{{$row->room_type_max_child}}" id="room_type_max_child" required type="number" name="room_type_max_child" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Banquet</label>
                                    <div class="controls">
                                        <input type="radio" value="1" @if($row->room_type_banquet == 1) checked @endif name="room_type_banquet" id="yes"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes">Yes</label>
                                        <input type="radio" value="0" @if($row->room_type_banquet == 0) checked @endif name="room_type_banquet" id="no"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no">No</label>
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