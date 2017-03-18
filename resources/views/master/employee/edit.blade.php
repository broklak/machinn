@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Edit {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
            {{csrf_field()}}
            <div class="row-fluid">
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Edit {{$master_module}} Data</h5>
                        </div>
                        <div class="widget-content nopadding">
                                <div id="form-wizard-1" class="step">
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Name</label>
                                        <div class="controls">
                                            <input value="{{$row->username}}" id="name" required type="text" name="username" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Department</label>
                                        <div class="controls">
                                            <select name="department_id">
                                                <option disabled selected>Choose {{$master_module}} Department</option>
                                                @foreach($department as $key => $val)
                                                    <option @if($row->department_id == $val['department_id']) selected="selected" @endif value="{{$val['department_id']}}">{{$val['department_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Type</label>
                                        <div class="controls">
                                            <select name="employee_type_id">
                                                <option disabled selected>Choose {{$master_module}} Type</option>
                                                @foreach($type as $key => $val)
                                                    <option @if($row->employee_type_id == $val['employee_type_id']) selected="selected" @endif value="{{$val['employee_type_id']}}">{{$val['employee_type_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Status</label>
                                        <div class="controls">
                                            <select name="employee_status_id">
                                                <option disabled selected>Choose {{$master_module}} Status</option>
                                                @foreach($status as $key => $val)
                                                    <option @if($row->employee_status_id == $val['employee_status_id']) selected="selected" @endif value="{{$val['employee_status_id']}}">{{$val['employee_status_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Email</label>
                                        <div class="controls">
                                            <input value="{{$row->email}}" id="email" type="email" name="email" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} N.I.K</label>
                                        <div class="controls">
                                            <input value="{{$row->nik}}" id="nik" type="text" name="nik" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} KTP</label>
                                        <div class="controls">
                                            <input value="{{$row->ktp}}" id="ktp" type="text" name="ktp" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Birth Place</label>
                                        <div class="controls">
                                            <input value="{{$row->birthplace}}" id="birthplace" type="text" name="birthplace" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Birth Date</label>
                                        <div class="controls">
                                            <input value="{{$row->birthdate}}" class="datepicker" id="birthdate" type="text" data-date-format="yyyy-mm-dd" name="birthdate" />
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Edit {{$master_module}} Data</h5>
                        </div>
                        <div class="widget-content nopadding">
                                <div id="form-wizard-1" class="step">
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Religion</label>
                                        <div class="controls">
                                            <select name="religion">
                                                <option disabled selected>Choose {{$master_module}} Religion</option>
                                                @foreach($religion as $val)
                                                    <option @if(strtolower($row->religion) == $val) selected="selected" @endif>{{ucfirst($val)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Gender</label>
                                        <div class="controls">
                                            <input type="radio" value="1" @if($row->gender == 1) checked @endif name="gender" id="male"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="male">Male</label>
                                            <input type="radio" value="2" @if($row->gender == 2) checked @endif name="gender" id="female"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="female">Female</label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Address</label>
                                        <div class="controls">
                                            <input value="{{$row->address}}" id="address" type="text" name="address" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Phone</label>
                                        <div class="controls">
                                            <input value="{{$row->phone}}" id="phone" type="text" name="phone" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Join Date</label>
                                        <div class="controls">
                                            <input value="{{$row->join_date}}" class="datepicker" id="join_date" data-date-format="yyyy-mm-dd" type="text" name="join_date" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} NPWP</label>
                                        <div class="controls">
                                            <input value="{{$row->npwp}}" id="npwp" type="text" name="npwp" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Bank Name</label>
                                        <div class="controls">
                                            <input value="{{$row->bank_name}}" id="bank_name" type="text" name="bank_name" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Bank Account Number</label>
                                        <div class="controls">
                                            <input value="{{$row->bank_number}}" id="bank_number" type="text" name="bank_number" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">{{$master_module}} Bank Account Name</label>
                                        <div class="controls">
                                            <input value="{{$row->bank_account_name}}" id="bank_account_name" type="text" name="bank_account_name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input id="next" class="btn btn-primary" type="submit" value="Save" />
                                    <div id="status"></div>
                                </div>
                                <div id="submitted"></div>
                                {{ method_field('PUT') }}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection