@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}?type={{$type}}">Add New {{$master_module}}</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Message</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Reminder Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->logbook_message}}</td>
                                        <td>{{\App\Logbook::getUserName($val->created_by)}}</td>
                                        <td>{{\App\User::getDepartmentName($val->to_dept_id)}}</td>
                                        <td>{{($val->to_date == null) ? '' : date('j F Y', strtotime($val->to_date))}}</td>
                                        <td>{{($val->done == 1) ? 'Done' : 'Not Done'}}</td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->logbook_id])}}?type={{$type}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                            <a style="margin-right: 20px" onclick="return confirm('You will delete this message, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->logbook_id, 'status' => $val->logbook_status])}}?type={{$type}}">
                                                <i class="icon-remove" aria-hidden="true"></i> Delete
                                            </a>
                                            <a href="{{route("$route_name.done", ['id' => $val->logbook_id])}}?type={{$type}}" title="Set Done"><i class="icon-check" aria-hidden="true"></i> Set Done</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center">No Data Found</td>
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