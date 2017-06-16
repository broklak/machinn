@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.invoicePayment')</a> <a href="#" class="current">@lang('web.add') @lang('module.invoicePayment')</a> </div>
        <h1>@lang('module.invoicePayment')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="{{route('invoice-payment.index')}}">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.addButton') Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.invoiceNumber')</label>
                                    <div class="controls">
                                        <select id="invoice_id" name="invoice_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($invoice as $key => $val)
                                                <option @if($row->invoice_id == $val['id']) selected="selected" @endif value="{{$val['id']}}">{{$val['invoice_number']}}</option>
                                            @endforeach
                                        </select>
                                        @foreach($invoice as $key => $val)
                                            <input type="hidden" id="invoice_amount_{{$val['id']}}" value="{{\App\Helpers\GlobalHelper::moneyFormatReport($val['amount'])}}" />
                                        @endforeach
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.paymentDate')</label>
                                    <div class="controls">
                                        <input id="date" required type="text" value="{{$row->payment_date}}" name="payment_date" data-date-format="yyyy-mm-dd" class="datepicker" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.paidAmount')</label>
                                    <div class="controls">
                                        <input id="paid_amount" required type="number" name="paid_amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.description')</label>
                                    <div class="controls">
                                        <input id="description" type="text" name="description" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.paidFrom')</label>
                                    <div class="controls">
                                        <select name="cash_account_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cash_account as $key => $val)
                                                <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
