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
                                    <label class="control-label">Outlet Type</label>
                                    <div class="controls">
                                        <select name="fnb">
                                            <option @if(old('fnb') == 0) selected @endif value="0">Select Type</option>
                                            <option @if(old('fnb') == 1) selected @endif value="1">Room Service</option>
                                            <option @if(old('fnb') == 2) selected @endif value="2">Outlet Resto</option>
                                            <option @if(old('fnb') == 3) selected @endif value="3">Outlet Banquet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Menu Category</label>
                                    <div class="controls">
                                        <select name="category_id">
                                            <option disabled @if(old('category_id') == 0) selected @endif value="0">Select Type</option>
                                            @foreach($category as $key => $val)
                                                <option @if(old('category_id') == $val->id) selected @endif value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Name</label>
                                    <div class="controls">
                                        <input id="name" value="{{old('name')}}" required type="text" name="name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Basic Cost</label>
                                    <div class="controls">
                                        <input onkeyup="formatMoney($(this))" id="cost_basic" value="{{old('cost_basic')}}" required type="text" name="cost_basic" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Price Before Tax</label>
                                    <div class="controls">
                                        <input id="cost_before_tax" value="{{old('cost_before_tax')}}" readonly type="text" name="cost_before_tax" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Price Sales</label>
                                    <div class="controls">
                                        <input onkeyup="getPriceBeforeTax($(this))" id="cost_sales" value="{{old('cost_sales')}}" required type="text" name="cost_sales" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tax</label>
                                    <div style="vertical-align: bottom" class="controls">
                                        @foreach($tax as $key => $val)
                                            <span style="margin-right: 10px;font-size: 12px;vertical-align: sub">{{$val->name}} ({{$val->percentage}}%)</span>
                                            @if($val->id == 1)
                                                <input type="hidden" id="tax-gov" value="{{$val->percentage}}">
                                            @endif
                                        @endforeach
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