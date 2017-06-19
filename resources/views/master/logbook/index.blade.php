@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.logBook')</a> </div>
        <h1>@lang('module.logBook')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}?type={{$type}}">@lang('web.addButton') @lang('module.logBook')</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.message')</th>
                                <th>@lang('web.from')</th>
                                <th>@lang('web.to')</th>
                                <th>@lang('web.reminderDate')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
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
                                            @if($val->done == 0)
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->logbook_id])}}?type={{$type}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            <a style="margin-right: 20px" onclick="return confirm('@lang('msg.confirmDelete', ['data' => ''])')" href="{{route("$route_name.change-status", ['id' => $val->logbook_id, 'status' => $val->logbook_status])}}?type={{$type}}">
                                                <i class="icon-remove" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                            <a href="{{route("$route_name.done", ['id' => $val->logbook_id])}}?type={{$type}}" title="Set Done"><i class="icon-check" aria-hidden="true"></i> @lang('web.setDone')</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center">@lang('msg.noData')</td>
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
