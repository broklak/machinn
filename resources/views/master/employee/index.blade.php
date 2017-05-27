@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$header}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($user['employee_type_id'] == 1)
            <a class="btn btn-primary" href="{{route($url.".create")}}">Add New {{$header}}</a>
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
                                <th>Role</th>
                                @if($header == 'Employee')
                                    <th>Department</th>
                                    <th>Status</th>
                                @endif
                                <th>Action</th>
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
                                                <a style="margin-right: 20px" href="{{route("$url.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                                <a onclick="return confirm('You will delete {{$val->name}}, continue? ')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$url.delete", ['id' => $val->id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete
                                                </a>
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