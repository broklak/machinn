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
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">Date</label>
                                    <div class="controls">
                                        <input value="{{$row->date}}" id="date" required type="text" name="date" class="datepicker" data-date-format="yyyy-mm-dd" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Amount</label>
                                    <div class="controls">
                                        <input value="{{$row->amount}}" id="amount" required type="number" name="amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <input value="{{$row->desc}}" id="desc" required type="text" name="desc" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Cost Type</label>
                                    <div class="controls">
                                        <select name="cost_id">
                                            <option disabled selected>Choose Cost Type</option>
                                            @foreach($cost as $key => $val)
                                                <option @if($row->cost_id == $val['cost_id']) selected="selected" @endif value="{{$val['cost_id']}}">{{$val['cost_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Department</label>
                                    <div class="controls">
                                        <select name="department_id">
                                            <option disabled selected>Choose Department</option>
                                            @foreach($department as $key => $val)
                                                <option @if($row->department_id == $val['department_id']) selected="selected" @endif value="{{$val['department_id']}}">{{$val['department_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Cash Source</label>
                                    <div class="controls">
                                        <select name="cash_account_id">
                                            <option disabled selected>Choose Cash Source</option>
                                            @foreach($cash as $key => $val)
                                                <option @if($row->cash_account_id == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
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
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection