@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($user['employee_type_id'] == 1)
            <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New {{$master_module}}</a>
        @endif
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->name}}</td>
                                        <td>{{$model->getTypeName($val->employee_type_id)}}</td>
                                        <td>{{$model->getDepartmentName($val->department_id)}}</td>
                                        <td>{{$model->getStatusName($val->employee_status_id)}}</td>
                                        <td>
                                            @if($val->employee_type_id != 1 && $user['employee_type_id'] == 1)
                                                <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                                <a onclick="return confirm('You will delete {{$val->name}}, continue? ')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete
                                                </a>
                                            @endif
                                            {{--@if($val->partner_status == 0)--}}
                                                {{--<a onclick="return confirm('You will activate {{$val->partner_name}}, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->partner_id, 'status' => $val->partner_status])}}"><i class="icon-check" aria-hidden="true"></i> Set Active</a>--}}
                                            {{--@else--}}
                                                {{--<a onclick="return confirm('You will deactivate {{$val->partner_name}}, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->partner_id, 'status' => $val->partner_status])}}"><i class="icon-remove" aria-hidden="true"></i> Set Not Active</a>--}}
                                            {{--@endif--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center">No Data Found</td>
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