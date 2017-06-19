<div id="dp-container" class="widget-box @if($row->status == 1) hide @endif ">
    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
        <h5>@lang('web.payBill')</h5>
    </div>
    <div class="widget-content nopadding">
        <div id="form-wizard-1" class="step">
            <input type="hidden" id="need_dp" />
            <div class="control-group">
                <label class="control-label">@lang('web.paymentMethod')</label>
                <div class="controls">
                    <select @if($row->status == 3) disabled @endif id="payment_method" name="payment_method">
                        <option value="0" disabled selected>@lang('web.choose')</option>
                        @foreach($payment_method as $key => $val)
                            <option @if(isset($payment->payment_method) && $payment->payment_method == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total @lang('web.billed')</label>
                <div class="controls">
                    <input readonly id="pay_bill" value="{{\App\Helpers\GlobalHelper::moneyFormatReport($row->grand_total)}}" type="text" name="pay_bill" />
                </div>
            </div>
            <div id="cash-cont" class="@if(isset($payment->payment_method) && !($payment->payment_method == 1 || $payment->payment_method == 2)) hide @endif">
                <div class="control-group">
                    <label class="control-label">@lang('web.totalPaid')</label>
                    <div class="controls">
                        <input @if($row->status == 3) disabled @endif onfocus="formatMoney($(this))" onkeyup="getChange($(this))" value="{{(isset($payment->total_paid)) ? \App\Helpers\GlobalHelper::moneyFormatReport($payment->total_paid) : 0}}" id="pay_paid" type="text" name="pay_paid" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.payChange')</label>
                    <div class="controls">
                        <input readonly id="pay_change" value="{{(isset($payment->total_change)) ? \App\Helpers\GlobalHelper::moneyFormatReport($payment->total_change) : 0}}" type="text" name="pay_change" />
                    </div>
                </div>
            </div>
            <div id="cc-container" class="@if(!isset($payment->payment_method) || $payment->payment_method != 3) hide @endif">
                <div class="control-group">
                    <label class="control-label">@lang('web.bookingPaymentDescriptionSettlement')</label>
                    <div class="controls">
                        <select @if($row->status == 3) disabled @endif name="settlement">
                            <option value="0" selected>@lang('web.choose')</option>
                            @foreach($settlement as $key => $val)
                                <option @if(isset($payment->settlement_id) && $payment->settlement_id == $val['settlement_id']) selected="selected" @endif value="{{$val['settlement_id']}}">{{$val['settlement_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.cardType')</label>
                    <div class="controls">
                        <input @if($row->status == 3) disabled @endif @if(isset($payment->settlement_id) && $payment->card_type == 1) checked @endif type="radio" value="1" name="card_type" id="cre"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="cre">Credit Card</label>
                        <input @if($row->status == 3) disabled @endif @if(isset($payment->settlement_id) && $payment->card_type == 2) checked @endif type="radio" value="2" name="card_type" id="deb"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="deb">Debit Card</label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.cardNumber')</label>
                    <div class="controls">
                        <input @if($row->status == 3) disabled @endif value="{{(isset($payment->settlement_id)) ? $payment->card_number : ''}}" id="card_number" type="text" name="card_number" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.cardHolder')</label>
                    <div class="controls">
                        <input @if($row->status == 3) disabled @endif value="{{(isset($payment->settlement_id)) ? $payment->cc_holder : ''}}" id="card_holder" type="text" name="card_holder" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.cardExpired')</label>
                        <div class="controls double-select">
                            <select @if($row->status == 3) disabled @endif class="month-select" name="month">
                                @foreach($month as $key => $val)
                                    <option @if(isset($payment->bank) && $payment->card_expiry_month == $key) selected @endif value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                            <select @if($row->status == 3) disabled @endif class="year-select" name="year">
                                @for($x=0; $x < $year_list; $x++)
                                    <option @if(isset($payment->bank) && $payment->card_expiry_year == date('Y') + $x) selected @endif>{{date('Y') + $x}}</option>
                                @endfor
                            </select>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label">@lang('web.ccType')</label>
                    <div class="controls">
                        <select @if($row->status == 3) disabled @endif name="cc_type">
                            <option value="0" selected>@lang('web.choose')</option>
                            @foreach($cc_type as $key => $val)
                                <option @if(isset($payment->bank) && $payment->cc_type_id == $val['cc_type_id']) selected="selected" @endif value="{{$val['cc_type_id']}}">{{$val['cc_type_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Bank</label>
                    <div class="controls">
                        <select @if($row->status == 3) disabled @endif name="bank">
                            <option value="0" selected>@lang('web.choose')</option>
                            @foreach($bank as $key => $val)
                                <option @if(isset($payment->bank) && $payment->bank == $val['bank_id']) selected="selected" @endif value="{{$val['bank_id']}}">{{$val['bank_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="bt-container" class="@if(!isset($payment->payment_method) || $payment->payment_method != 4) hide @endif">
                <div class="control-group">
                    <label class="control-label">@lang('web.accountRecipient')</label>
                    <div class="controls">
                        <select @if($row->status == 3) disabled @endif name="cash_account_id">
                            <option value="0" selected>@lang('web.choose')</option>
                            @foreach($cash_account as $key => $val)
                                <option @if(isset($payment->bank) && $payment->bank_transfer_recipient == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
