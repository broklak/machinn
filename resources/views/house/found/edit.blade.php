@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">@lang('web.add') @lang('module.found')</a> </div>
        <h1>@lang('module.found')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
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
                            <h5>@lang('web.edit') @lang('module.found')</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.lostItem')</label>
                                    <div class="controls">
                                        <select id="lost_id" name="lost_id">
                                            <option value="0">@lang('web.choose')</option>
                                            @foreach($lost as $key => $val)
                                                <option @if($row->lost_id == $val->id) selected @endif data-itemname="{{$val->item_name}}" data-itemcolor="{{$val->item_color}}" id="opt-{{$val->id}}"
                                                        data-itemvalue="{{$val->item_value}}" data-itemplace="{{$val->place}}" data-itemdesc="{{$val->description}}"
                                                        value="{{$val->id}}">{{$val->item_name . '-'. $val->item_color}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.date')</label>
                                    <div class="controls">
                                        <input id="date" required class="datepicker" value="{{$row->date}}" data-date-format="yyyy-mm-dd" type="text" name="date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.itemName')</label>
                                    <div class="controls">
                                        <input id="item_name" required type="text" value="{{$row->item_name}}" name="item_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.color')</label>
                                    <div class="controls">
                                        <input id="item_color" type="text"  value="{{$row->item_color}}" name="item_color" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.itemValue')</label>
                                    <div class="controls">
                                        <input id="item_value" type="text" value="{{$row->item_value}}" name="item_value" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.placeMissing')</label>
                                    <div class="controls">
                                        <input id="place" type="text" value="{{$row->place}}" name="place" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.desc')</label>
                                    <div class="controls">
                                        <textarea id="desc" name="description">{{$row->description}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.founderName')</label>
                                    <div class="controls">
                                        <input id="employee_id" type="hidden" name="founder_employee_id" value="{{$row->founder_employee_id}}">
                                        <input id="founder_name" value="{{$row->founder_name}}" required type="text" name="founder_name" />
                                        <a href="#modalFindEmployee" data-toggle="modal" class="btn btn-inverse">@lang('web.findEmployee')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="@lang('web.save')">
            </div>
            {{ method_field('PUT') }}
        </form>
    </div>

    <div id="modalFindEmployee" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>@lang('web.findEmployee')</h3>
        </div>
        <div class="modal-body">
            <form id="searchEmployeeForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-employee" class="step">
                    <div class="control-group">
                        <label class="control-label">@lang('web.searchName')</label>
                        <div class="controls">
                            <input id="searchemployee" name="query" type="text" />
                            <input type="submit" value="@lang('web.submitSearch')" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('web.name')</th>
                    <th>ID</th>
                    <th>@lang('web.action')</th>
                </tr>
                </thead>
                <tbody id="listEmployee">
                @foreach($employee as $key => $val)
                    <tr class="{{($val['id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                        <td>{{$val['username']}}</td>
                        <td>{{\App\User::getDepartmentName($val['department_id'])}}</td>
                        <td><a data-dismiss="modal" data-name="{{$val['username']}}" data-id="{{$val['id']}}" id="employee-{{$val['id']}}"
                               class="btn btn-success chooseEmployee">@lang('web.choose')</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
