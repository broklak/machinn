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
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->property_attribute_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Name</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->property_attribute_name}}" name="property_attribute_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Category</label>
                                    <div class="controls">
                                        <select name="type">
                                            <option @if($row->type == 1) selected @endif value="1">Furniture Hotel</option>
                                            <option @if($row->type == 2) selected @endif value="2">Electronic</option>
                                            <option @if($row->type == 3) selected @endif value="3">Kitchen Equipment</option>
                                            <option @if($row->type == 4) selected @endif value="4">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Purchase Date</label>
                                    <div class="controls">
                                        <input value="{{$row->purchase_date}}" id="purchase_date" data-date-format="yyyy-mm-dd" class="datepicker" required type="text" name="purchase_date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Purchase Amount</label>
                                    <div class="controls">
                                        <input value="{{$row->purchase_amount}}" id="purchase_amount" required type="number" name="purchase_amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Quantity</label>
                                    <div class="controls">
                                        <input  value="{{$row->qty}}" id="qty" required type="number" name="qty" />
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