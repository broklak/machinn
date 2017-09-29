@php
@endphp
@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('web.cashBankAccount')</a> </div>
        <h1>@lang('web.cashBankAccount')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($user['employee_type_id'] == 1)
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') @lang('web.cashBankAccount')</a>
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
                                <th>@lang('web.desc')</th>
                                <th>@lang('master.cashBankOpenBalance')</th>
                                <th>@lang('master.cashBankOpenDate')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->cash_account_name}}</td>
                                        <td>{{$val->cash_account_desc}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->open_balance)}}</td>
                                        <td>{{($val->open_date != null) ? date('j F Y', strtotime($val->open_date)) : '' }}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->cash_account_status)!!}</td>
                                        <td>
                                            @if($user['employee_type_id'] == 1)
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->cash_account_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            @if($val->type == 1)
                                            <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->cash_account_name])')"
                                               class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->cash_account_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center">@lang('msg.noData')</td>
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
