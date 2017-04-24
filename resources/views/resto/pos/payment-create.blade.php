<div id="dp-container" class="widget-box hide">
    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
        <h5>Pay Bill</h5>
    </div>
    <div class="widget-content nopadding">
        <div id="form-wizard-1" class="step">
            <input type="hidden" id="need_dp" />
            <div class="control-group">
                <label class="control-label">Payment Method</label>
                <div class="controls">
                    <select id="payment_method" name="payment_method">
                        <option value="0" disabled selected>Choose Payment Method</option>
                        @foreach($payment_method as $key => $val)
                            <option @if(old('payment_method') == $val) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Bill</label>
                <div class="controls">
                    <input id="pay_bill" type="number" name="pay_bill" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Total Paid</label>
                <div class="controls">
                    <input id="pay_paid" type="number" name="pay_bill" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Change</label>
                <div class="controls">
                    <input id="pay_change" type="number" name="pay_change" />
                </div>
            </div>
            <div id="cc-container" class="hide">
                <div class="control-group">
                    <label class="control-label">Settlement</label>
                    <div class="controls">
                        <select name="settlement">
                            <option value="0" selected>Choose Settlement</option>
                            @foreach($settlement as $key => $val)
                                <option @if(old('settlement') == $val['settlement_id']) selected="selected" @endif value="{{$val['settlement_id']}}">{{$val['settlement_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Card Type</label>
                    <div class="controls">
                        <input type="radio" value="1" name="card_type" id="cre"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="cre">Credit Card</label>
                        <input type="radio" value="2" name="card_type" id="deb"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="deb">Debit Card</label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Card Number</label>
                    <div class="controls">
                        <input value="{{old('card_number')}}" id="card_number" type="text" name="card_number" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Card Holder Name</label>
                    <div class="controls">
                        <input value="{{old('card_holder')}}" id="card_holder" type="text" name="card_holder" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Card Expired Date</label>
                    <div class="controls">
                        <input value="{{old('card_expired_date')}}" id="card_expired_date" type="text" data-date-format="yyyy-mm-dd" name="card_expired_date" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Credit Card Type</label>
                    <div class="controls">
                        <select name="cc_type">
                            <option value="0" selected>Choose CC Type</option>
                            @foreach($cc_type as $key => $val)
                                <option @if(old('cc_type') == $val['cc_type_id']) selected="selected" @endif value="{{$val['cc_type_id']}}">{{$val['cc_type_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Bank</label>
                    <div class="controls">
                        <select name="bank">
                            <option value="0" selected>Choose Bank</option>
                            @foreach($bank as $key => $val)
                                <option @if(old('bank') == $val['bank_id']) selected="selected" @endif value="{{$val['bank_id']}}">{{$val['bank_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="bt-container" class="hide">
                <div class="control-group">
                    <label class="control-label">Account Recipient</label>
                    <div class="controls">
                        <select name="cash_account_id">
                            <option value="0" selected>Choose Recipient</option>
                            @foreach($cash_account as $key => $val)
                                <option @if(old('cash_account_id') == $val['cash_account_id']) selected="selected" @endif value="{{$val['cash_account_id']}}">{{$val['cash_account_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>