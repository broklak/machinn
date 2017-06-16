@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Edit {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.edit') Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.incomeType')</label>
                                    <div class="controls">
                                        <select id="type" name="type">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($type as $key => $val)
                                                <option @if($row->type == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.date')</label>
                                    <div class="controls">
                                        <input id="date" value="{{$row->date}}" required type="text" name="date" data-date-format="yyyy-mm-dd" class="datepicker" />
                                    </div>
                                </div>

                                <div id="other" class="control-group @if($row->type != 3) hide @endif">
                                    <label class="control-label">@lang('web.type')</label>
                                    <div class="controls">
                                        <select id="income_id" name="income_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($income as $key => $val)
                                                <option @if($row->income_id == $val['income_id']) selected="selected" @endif value="{{$val['income_id']}}">{{$val['income_name']}}</option>
                                            @endforeach
                                        </select>
                                        @foreach($income as $key => $val)
                                            <input type="hidden" id="income_amount_{{$val['income_id']}}" value="{{$val['income_amount']}}" />
                                        @endforeach
                                    </div>
                                </div>
                                <div id="piutang" class="control-group  @if($row->type != 2) hide @endif">
                                    <label class="control-label">@lang('module.account-receivable')</label>
                                    <div class="controls">
                                        <select id="account_receivable_id" name="account_receivable_id">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($unpaidBook as $key => $val)
                                                <option @if($row->account_receivable_id == $val->booking_id) selected="selected" @endif
                                                value="{{$val->booking_id}}">Booking {{\App\BookingHeader::getBookingCode($val->booking_id)}} - {{\App\Helpers\GlobalHelper::moneyFormatReport($val->total)}} - {{\App\Partner::getName($val->partner_id)}}</option>
                                            @endforeach
                                        </select>
                                        @foreach($unpaidBook as $key => $val)
                                            <input type="hidden" id="ar_amount_{{$val->booking_id}}" value="{{$val->total}}" />
                                        @endforeach
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.accountRecipient')</label>
                                    <div class="controls">
                                        <select name="cash_account_recipient">
                                            <option disabled selected>@lang('web.choose')</option>
                                            @foreach($cash_account as $key => $val)
                                                <option @if($row->cash_account_recipient == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.amount')</label>
                                    <div class="controls">
                                        <input id="amount" value="{{$row->amount}}" required type="number" name="amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.description')</label>
                                    <div class="controls">
                                        <input id="description" value="{{$row->desc}}" type="text" name="description" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
