@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$header}}</a> </div>
        <h1>{{$header}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($user['employee_type_id'] == 1)
            <a class="btn btn-primary" href="{{route($url.".create")}}">@lang('web.addButton') {{$header}}</a>
        @endif
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>@lang('master.role')</th>
                                @if($header == 'Employee')
                                    <th>@lang('web.department')</th>
                                    <th>Status</th>
                                @endif
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->name}}</td>
                                        <td>{{$model->getTypeName($val->employee_type_id)}}</td>
                                        @if($header == 'Employee')
                                            <td>{{$model->getDepartmentName($val->department_id)}}</td>
                                            <td>{{$model->getStatusName($val->employee_status_id)}}</td>
                                        @endif
                                        <td>
                                                <a style="margin-right: 20px" href="{{route("$url.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                                <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->name])')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$url.delete", ['id' => $val->id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                                </a>
                                        </td>
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
