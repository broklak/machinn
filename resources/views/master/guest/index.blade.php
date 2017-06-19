@extends('layout.main')

@section('title', 'Home')

@section('content')

    @php $route = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'guest.' : '' @endphp

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('web.guest')</a> </div>
        <h1>@lang('web.guest')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route($route_name.'.'.$route.'create')}}">@lang('web.addButton') @lang('web.guest')</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>@lang('web.idNumber')</th>
                                <th>@lang('web.gender')</th>
                                <th>@lang('web.handphone')</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->first_name}} {{$val->last_name}}</td>
                                        <td>{{$val->id_number}} ({{\App\Guest::getIdType($val->id_type)}})</td>
                                        <td>@if($val->gender == 1) Male @else Female @endif</td>
                                        <td>{{$val->handphone}}</td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route($route_name.'.'.$route.'edit', ['id' => $val->guest_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->first_name])')"
                                               class="delete-link" style="margin-right: 20px" href="{{route($route_name.'.'.$route.'delete', ['id' => $val->guest_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" style="text-align: center">@lang('msg.noData')</td>
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
