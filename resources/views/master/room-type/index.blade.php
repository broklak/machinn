@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('web.roomType')</a> </div>
        <h1>@lang('web.roomType')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($user['employee_type_id'] == 1)
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') @lang('web.roomType')</a>
        @endif
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.roomType')</th>
                                <th>@lang('web.maxAdult')</th>
                                <th>@lang('web.maxChild')</th>
                                <th>@lang('web.weekdayPrice')</th>
                                <th>@lang('web.weekdayPrice')</th>
                                <th>@lang('module.banquet')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->room_type_name}}</td>
                                        <td>{{$val->room_type_max_adult}}</td>
                                        <td>{{$val->room_type_max_child}}</td>
                                        <td>{{\App\RoomRate::getRate(1, $val->room_type_id)}}</td>
                                        <td>{{\App\RoomRate::getRate(2, $val->room_type_id)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::setYesOrNo($val->room_type_banquet)}}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->room_type_status)!!}</td>
                                        <td>
                                            @if($user['employee_type_id'] == 1)
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->room_type_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->room_type_name])')"
                                               class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->room_type_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                            @if($val->room_type_status == 0)
                                                <a onclick="return confirm('@lang('msg.confirmActivate', ['data' => $val->room_type_name])')" href="{{route("$route_name.change-status", ['id' => $val->room_type_id, 'status' => $val->room_type_status])}}"><i class="icon-check" aria-hidden="true"></i> @lang('web.setActive')</a>
                                            @else
                                                <a onclick="return confirm('@lang('msg.confirmNotActivate', ['data' => $val->room_type_name])')" href="{{route("$route_name.change-status", ['id' => $val->room_type_id, 'status' => $val->room_type_status])}}"><i class="icon-remove" aria-hidden="true"></i> @lang('web.setNotActive')</a>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center">@lang('web.msg.noData')</td>
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
