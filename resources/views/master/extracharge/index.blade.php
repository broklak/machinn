@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.extracharge')</a> </div>
        <h1>@lang('module.extracharge')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') @lang('module.extracharge')</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>@lang('web.price')</th>
                                <th>@lang('web.category')</th>
                                <th>@lang('web.type')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->extracharge_name}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->extracharge_price)}}</td>
                                        <td>{{$model->getGroupName($val->extracharge_group_id)}}</td>
                                        <td>{{$model->getTypeName($val->extracharge_type)}}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->extracharge_status)!!}</td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->extracharge_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->extracharge_name])')"
                                               class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->extracharge_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                            @if($val->extracharge_status == 0)
                                                <a onclick="return confirm('@lang('msg.confirmActivate', ['data' => $val->extracharge_name])')" href="{{route("$route_name.change-status", ['id' => $val->extracharge_id, 'status' => $val->extracharge_status])}}"><i class="icon-check" aria-hidden="true"></i> @lang('web.setActive')</a>
                                            @else
                                                <a onclick="return confirm('@lang('msg.confirmNotActivate', ['data' => $val->extracharge_name])')" href="{{route("$route_name.change-status", ['id' => $val->extracharge_id, 'status' => $val->extracharge_status])}}"><i class="icon-remove" aria-hidden="true"></i> @lang('web.setNotActive')</a>
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
