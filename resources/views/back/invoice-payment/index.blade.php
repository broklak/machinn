@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.invoicePayment')</a> </div>
        <h1>@lang('module.invoicePayment')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                <div class="control-group">
                    <label class="control-label">@lang('web.chooseDateRange')</label>
                    <div class="controls">
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" value="@lang('web.submitSearch')" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') Data</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.paymentDate')</th>
                                <th>@lang('web.dueDate')</th>
                                <th>@lang('web.invoiceNumber')</th>
                                <th>@lang('web.paidFrom')</th>
                                <th>@lang('web.costType')</th>
                                <th>@lang('web.paidTo')</th>
                                <th>@lang('web.amount')</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->payment_date))}}</td>
                                        <td>{{date('j F Y', strtotime($val->due_date))}}</td>
                                        <td>{{$val->invoice_number}}</td>
                                        <td>{{\App\CashAccount::getName($val->cash_account_id)}}</td>
                                        <td>{{\App\Cost::getCostName($val->cost_id)}}</td>
                                        <td>{{\App\Partner::getName($val->source_id)}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormatReport($val->paid_amount)}}</td>
                                        <td>
                                            @if($val->status == 0)
                                                <a style="margin-right: 20px;display:none" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                                <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->invoice_number])')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                                </a>
                                            @endif
                                            {{--@if($val->status == 0)--}}
                                                {{--<a onclick="return confirm('You will approve {{$val->invoice_number}}, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->id, 'status' => $val->status])}}"><i class="icon-check" aria-hidden="true"></i> Set Approved</a>--}}
                                            {{--@else--}}
                                                {{--<a onclick="return confirm('You will unapprove {{$val->invoice_number}}, continue? ')" href="{{route("$route_name.change-status", ['id' => $val->id, 'status' => $val->status])}}"><i class="icon-remove" aria-hidden="true"></i> Set Unapproved</a>--}}
                                            {{--@endif--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center">@lang('msg.noData')</td>
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
