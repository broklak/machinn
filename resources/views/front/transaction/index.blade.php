@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.transaction' : 'transaction'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.expense')</a> </div>
        <h1>@lang('module.expense')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                <div class="control-group">
                    <label class="control-label">@lang('web.chooseDateRange')</label>
                    <div class="controls">
                        <input value="{{$filter['start']}}" id="checkin" type="text" name="start" />
                        <input value="{{$filter['end']}}" id="checkout" type="text" name="end" />
                        <input type="submit" style="vertical-align: top" value="@lang('web.search')" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') Data</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.date')</th>
                                <th>@lang('web.costType')</th>
                                <th>@lang('web.source')</th>
                                <th>@lang('web.desc')</th>
                                <th>@lang('web.amount')</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{\App\Cost::getCostName($val->cost_id)}}</td>
                                        <td>{{\App\CashAccount::getName($val->cash_account_id)}}</td>
                                        <td>{{$val->desc}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->amount)}}</td>
                                        {{--<td>{{\App\FrontExpenses::getStatusName($val->status)}}</td>--}}
                                        <td>
                                            @if($val->status != 1)
                                                <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit">
                                                    <i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')
                                                </a>
                                                <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => ''])')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                                </a>
                                            @endif
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
