@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.staffContact')</a> </div>
        <h1>@lang('module.staffContact')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <form>
                        <input placeholder="@lang('web.searchName')" value={{$name}} value="ler" id="name" type="text" name="name" />
                        <select name="department">
                            <option value="0">@lang('web.allDepartment')</option>
                            @foreach($department as $key => $val)
                                <option value="{{$val->department_id}}">{{$val->department_name}}</option>
                            @endforeach
                        </select>
                        <input type="submit" style="vertical-align: top" value="@lang('web.search')" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>@lang('web.type')</th>
                                <th>@lang('web.department')</th>
                                <th>@lang('web.handphone')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->name}}</td>
                                        <td>{{$model->getTypeName($val->employee_type_id)}}</td>
                                        <td>{{$model->getDepartmentName($val->department_id)}}</td>
                                        <td>{{$val->phone}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center">@lang('msg.noData')</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection
