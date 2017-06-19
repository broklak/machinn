@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.roleManagement')</a> <a href="#" class="current">@lang('web.edit') @lang('master.role')</a> </div>
        <h1>@lang('module.roleManagement')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->employee_type_id])}}" method="post">
                    {{csrf_field()}}
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.edit') @lang('master.role')</h5>
                    </div>
                    <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.roleName')</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->employee_type_name}}" name="employee_type_name" />
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Access Control List</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2">@lang('master.moduleName')</th>
                                    <th rowspan="2">@lang('web.action')</th>
                                    <th>@lang('master.create')</th>
                                    <th>@lang('master.read')</th>
                                    <th>@lang('master.update')</th>
                                    <th>@lang('master.delete')</th>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" onchange="checkAll(this, 'checkCreate')" /></th>
                                    <th><input type="checkbox" onchange="checkAll(this, 'checkRead')" /></th>
                                    <th><input type="checkbox" onchange="checkAll(this, 'checkUpdate')" /></th>
                                    <th><input type="checkbox" onchange="checkAll(this, 'checkDelete')" /></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($submodules as $key => $val)
                                    <tr>
                                        <td>{{$val->submodule_name}}</td>
                                        <td style="text-align: center">
                                            <a data-id="{{$val->submodule_id}}" id="grant-{{$val->submodule_id}}" onclick="grantAll($(this))" class="btn btn-success">@lang('master.grantAll')</a>
                                            <a data-id="{{$val->submodule_id}}" id="revoke-{{$val->submodule_id}}" onclick="revokeAll($(this))" class="btn btn-danger hide">@lang('master.revokeAll')</a>
                                        </td>
                                        <td>
                                            <input @if(\App\UserRole::checkAccess($val->submodule_id, 'create', $row->employee_type_id)) checked @endif
                                            class="checkCreate" type="checkbox" value="{{$val->submodule_id}}"
                                                   id="create-{{$val->submodule_id}}" name="create[]">
                                        </td>
                                        <td>
                                            <input @if(\App\UserRole::checkAccess($val->submodule_id, 'read', $row->employee_type_id)) checked @endif
                                            class="checkRead" type="checkbox" value="{{$val->submodule_id}}" id="read-{{$val->submodule_id}}"
                                                   name="read[]">
                                        </td>
                                        <td>
                                            <input @if(\App\UserRole::checkAccess($val->submodule_id, 'update', $row->employee_type_id)) checked @endif
                                            class="checkUpdate" type="checkbox" value="{{$val->submodule_id}}" id="update-{{$val->submodule_id}}"
                                                   name="update[]">
                                        </td>
                                        <td>
                                            <input @if(\App\UserRole::checkAccess($val->submodule_id, 'delete', $row->employee_type_id)) checked @endif
                                            class="checkDelete" type="checkbox" value="{{$val->submodule_id}}" id="delete-{{$val->submodule_id}}" name="delete[]">
                                        </td>
                                    </tr>
                                    <input type="hidden" name="submodule_id[]" value="{{$val->submodule_id}}" />
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE">
                            <div id="status"></div>
                        </div>
                        <div id="submitted"></div>
                    </div>
                    {{ method_field('PUT') }}
                </form>
            </div>
        </div>
    </div>

@endsection
