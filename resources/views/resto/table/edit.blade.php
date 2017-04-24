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
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">Name</label>
                                    <div class="controls">
                                        <input id="name" value="{{$row->name}}" required type="text" name="name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="desc">{{$row->desc}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Type</label>
                                    <div class="controls">
                                        <input @if($row->type == 1) checked @endif type="radio" value="1" name="type" id="resto"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="resto">Resto</label>
                                        <input @if($row->type == 2) checked @endif type="radio" value="2" name="type" id="banq"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="banq">Banquet</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="Save" />
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