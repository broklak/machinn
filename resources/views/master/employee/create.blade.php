@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$url.index")}}">{{$header}}</a> <a href="#" class="current">Create {{$header}}</a> </div>
        <h1>{{$header}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <form id="form-wizard" class="form-horizontal" action="{{route("$url.store")}}" method="post">
            {{csrf_field()}}
            <div class="row-fluid">
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                                <h5>{{$header}}</h5>
                            </div>
                            <div class="widget-content nopadding">
                                    <div id="form-wizard-1" class="step">
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.name')</label>
                                            <div class="controls">
                                                <input value="{{old('username')}}" id="name" required type="text" name="username" />
                                            </div>
                                        </div>
                                         <div class="control-group">
                                             <label class="control-label">Password</label>
                                             <div class="controls">
                                                 <input id="password" required type="password" name="password" />
                                             </div>
                                         </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.department')</label>
                                            <div class="controls">
                                                <select name="department_id">
                                                    <option disabled selected>@lang('web.choose')</option>
                                                    @foreach($department as $key => $val)
                                                        <option @if(old('department_id') == $val['department_id']) selected="selected" @endif value="{{$val['department_id']}}">{{$val['department_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('master.role')</label>
                                            <div class="controls">
                                                <select name="employee_type_id">
                                                    <option disabled selected>@lang('web.choose')</option>
                                                    @foreach($type as $key => $val)
                                                        <option @if(old('employee_type_id') == $val['employee_type_id']) selected="selected" @endif value="{{$val['employee_type_id']}}">{{$val['employee_type_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Status</label>
                                            <div class="controls">
                                                <select name="employee_status_id">
                                                    <option disabled selected>@lang('web.choose')</option>
                                                    @foreach($status as $key => $val)
                                                        <option @if(old('employee_status_id') == $val['employee_status_id']) selected="selected" @endif value="{{$val['employee_status_id']}}">{{$val['employee_status_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Email</label>
                                            <div class="controls">
                                                <input value="{{old('email')}}" id="email" type="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">N.I.K</label>
                                            <div class="controls">
                                                <input value="{{old('nik')}}" id="nik" type="text" name="nik" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">KTP</label>
                                            <div class="controls">
                                                <input value="{{old('ktp')}}" id="ktp" type="text" name="ktp" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.birthplace')</label>
                                            <div class="controls">
                                                <input value="{{old('birthplace')}}" id="birthplace" type="text" name="birthplace" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.birthdate')</label>
                                            <div class="controls">
                                                <input value="{{old('birthdate')}}" class="datepicker" id="birthdate" type="text" data-date-format="yyyy-mm-dd" name="birthdate" />
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                                <h5>{{$header}} Personal Data</h5>
                            </div>
                            <div class="widget-content nopadding">
                                    <div id="form-wizard-1" class="step">
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.religion')</label>
                                            <div class="controls">
                                                <select name="religion">
                                                    <option disabled selected>@lang('web.choose')</option>
                                                    @foreach($religion as $val)
                                                        <option @if(old('religion') == $val) selected="selected" @endif>{{ucfirst($val)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.gender')</label>
                                            <div class="controls">
                                                <input type="radio" value="1" name="gender" id="male"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="male">@lang('web.male')</label>
                                                <input type="radio" value="2" checked name="gender" id="female"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="female">@lang('web.female')</label>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.address')</label>
                                            <div class="controls">
                                                <input value="{{old('address')}}" id="address" type="text" name="address" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('web.phone')</label>
                                            <div class="controls">
                                                <input value="{{old('phone')}}" id="phone" type="text" name="phone" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('master.joinDate')</label>
                                            <div class="controls">
                                                <input value="{{old('join_date')}}" class="datepicker" id="join_date" data-date-format="yyyy-mm-dd" type="text" name="join_date" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">NPWP</label>
                                            <div class="controls">
                                                <input value="{{old('npwp')}}" id="npwp" type="text" name="npwp" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('master.bankName')</label>
                                            <div class="controls">
                                                <input value="{{old('bank_name')}}" id="bank_name" type="text" name="bank_name" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('master.bankAccount')</label>
                                            <div class="controls">
                                                <input value="{{old('bank_number')}}" id="bank_number" type="text" name="bank_number" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">@lang('master.bankAccountHolder')</label>
                                            <div class="controls">
                                                <input value="{{old('bank_account_name')}}" id="bank_account_name" type="text" name="bank_account_name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                        <div id="status"></div>
                                    </div>
                                    <div id="submitted"></div>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>

@endsection
