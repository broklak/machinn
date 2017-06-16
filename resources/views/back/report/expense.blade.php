@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.transaction' : 'transaction'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>@lang('module.expenseReport')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                <div class="control-group">
                    <label class="control-label">@lang('web.choose') @lang('web.department')</label>
                    <div class="controls">
                        <select name="department_id" onchange="this.form.submit()">
                            <option value="0">@lang('web.all') @lang('web.department')</option>
                            @foreach($department as $key => $val)
                                <option @if($filter['department_id'] == $val->department_id) selected @endif value="{{$val->department_id}}">{{$val->department_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.choose') @lang('web.cashBankAccount')</label>
                    <div class="controls">
                        <select name="cash_account_id" onchange="this.form.submit()">
                            <option value="0">@lang('web.all') @lang('web.account')</option>
                            @foreach($cash_account as $key => $val)
                                <option @if($filter['cash_account_id'] == $val->cash_account_id) selected @endif value="{{$val->cash_account_id}}">{{$val->cash_account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.chooseDateRange')</label>
                    <div class="controls">
                        <input value="{{$filter['start']}}" id="checkin" type="text" name="start" />
                        <input value="{{$filter['end']}}" id="checkout" type="text" name="end" />
                        <input type="submit" style="vertical-align: top" value="@lang('web.submitSearch')" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <div style="float: right">
            <a href="{{route('back.excel.expense')}}?start={{$filter['start']}}&end={{$filter['end']}}&cash_account_id={{$filter['cash_account_id']}}&department_id={{$filter['department_id']}}" class="btn btn-success">@lang('web.exportCsv')</a>
        </div>
        <div style="clear: both;"></div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($filter['start']))}} - {{date('j F Y', strtotime($filter['end']))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.date')</th>
                                <th>@lang('web.cost')</th>
                                <th>@lang('web.department')</th>
                                <th>@lang('web.from') @lang('web.account')</th>
                                <th>@lang('web.description')</th>
                                <th>@lang('web.amount')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @php $total = 0; @endphp
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{\App\Cost::getCostName($val->cost_id)}}</td>
                                        <td>{{\App\Department::getName($val->department_id)}}</td>
                                        <td>{{\App\CashAccount::getName($val->cash_account_id)}}</td>
                                        <td>{{$val->desc}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->amount)}}</td>
                                    </tr>
                                    @php $total = $total + $val->amount; @endphp
                                @endforeach
                                <tr>
                                    <td colspan="5" class="summary-td" style="text-align: right">TOTAL</td>
                                    <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($total)}}</td>
                                </tr>
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
