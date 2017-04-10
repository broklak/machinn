@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New {{$master_module}}</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Number</th>
                                <th>Type</th>
                                <th>Floor</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->room_number_code}}</td>
                                        <td>{{$model->getTypeName($val->room_type_id)}}</td>
                                        <td>{{$model->getFloorName($val->room_floor_id)}}</td>
                                        <td><span class="label label-{{\App\Helpers\GlobalHelper::setButtonStatus($val->hk_status)}}">{{\App\Helpers\GlobalHelper::setStatusName($val->hk_status)}}</span></td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->room_number_code])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                            <a onclick="return confirm('You will delete {{$val->room_number_code}}, continue? ')"
                                               class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->room_number_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete
                                            </a>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn dropdown-toggle">Change Status <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    @foreach($status as $key => $val_status)
                                                        <li><a href="{{route($route_name.'.change-status', ['id' => $val->room_number_id, 'status' => $key])}}">{{$val_status}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
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