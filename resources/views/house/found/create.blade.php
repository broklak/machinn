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
        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
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
                                        <label class="control-label">Lost Item</label>
                                        <div class="controls">
                                            <select id="lost_id" name="lost_id">
                                                <option>Choose Lost Item</option>
                                                @foreach($lost as $key => $val)
                                                    <option data-itemname="{{$val->item_name}}" data-itemcolor="{{$val->item_color}}" id="opt-{{$val->id}}"
                                                            data-itemvalue="{{$val->item_value}}" data-itemplace="{{$val->place}}" data-itemdesc="{{$val->description}}"
                                                            value="{{$val->id}}">{{$val->item_name . '-'. $val->item_color}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Founded</label>
                                        <div class="controls">
                                            <input id="date" required class="datepicker" value="{{old('date')}}" data-date-format="yyyy-mm-dd" type="text" name="date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Item Name</label>
                                        <div class="controls">
                                            <input id="item_name" required type="text" value="{{old('item_name')}}" name="item_name" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Color</label>
                                        <div class="controls">
                                            <input id="item_color" type="text"  value="{{old('item_color')}}" name="item_color" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Item Value</label>
                                        <div class="controls">
                                            <input id="item_value" type="text" value="{{old('item_value')}}" name="item_value" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Place Missing</label>
                                        <div class="controls">
                                            <input id="place" type="text" value="{{old('place')}}" name="place" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            <textarea id="desc" name="description">{{old('description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Founder Name</label>
                                        <div class="controls">
                                            <input id="employee_id" type="hidden" name="founder_employee_id" value="{{old('founder_employee_id')}}">
                                            <input id="founder_name" value="{{old('founder_name')}}" required type="text" name="founder_name" />
                                            <a href="#modalFindEmployee" data-toggle="modal" class="btn btn-inverse">Find Employee</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE">
        </div>
        </form>
    </div>

    <div id="modalFindEmployee" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Find Employee</h3>
        </div>
        <div class="modal-body">
            <form id="searchEmployeeForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-employee" class="step">
                    <div class="control-group">
                        <label class="control-label">Filter Employee By Name</label>
                        <div class="controls">
                            <input id="searchemployee" name="query" type="text" />
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="listEmployee">
                @foreach($employee as $key => $val)
                    <tr class="{{($val['id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                        <td>{{$val['username']}}</td>
                        <td>{{\App\User::getDepartmentName($val['department_id'])}}</td>
                        <td><a data-dismiss="modal" data-name="{{$val['username']}}" data-id="{{$val['id']}}" id="employee-{{$val['id']}}"
                               class="btn btn-success chooseEmployee">Choose</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection