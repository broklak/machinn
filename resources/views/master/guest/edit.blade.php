@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'guest' : '' @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.$route.index")}}">{{$master_module}}</a> <a href="#" class="current">Edit {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Edit {{$master_module}} Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.$route.update", ['id' => $row->guest_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <input type="hidden" name="guest_id" id="guest_id">
                                <div class="control-group">
                                    <label class="control-label">Guest Title</label>
                                    <div class="controls">
                                        <input type="radio" @if($row->title == 1) checked @endif value="1" name="guest_title" id="mr"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mr">Mr</label>
                                        <input type="radio" @if($row->title == 2) checked @endif value="2" name="guest_title" id="mrs"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mrs">Mrs</label>
                                        <input type="radio" @if($row->title == 3) checked @endif value="3" name="guest_title" id="mis"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="mis">Miss</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">First Name</label>
                                    <div class="controls">
                                        <input value="{{$row->first_name}}" id="first_name" type="text" name="first_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Last Name</label>
                                    <div class="controls">
                                        <input value="{{$row->last_name}}" id="last_name" type="text" name="last_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Guest Type</label>
                                    <div class="controls">
                                        <input type="radio" @if($row->type == 1) checked @endif value="1" name="guest_type" id="reg"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="reg">Regular</label>
                                        <input type="radio" @if($row->type == 2) checked @endif value="2" name="guest_type" id="vip"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="vip">VIP</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">ID Type</label>
                                    <div class="controls">
                                        <select id="id_type" name="id_type">
                                            <option value="0" disabled selected>Choose ID Type</option>
                                            @foreach($idType as $key => $val)
                                                <option @if($row->id_type == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">ID Number</label>
                                    <div class="controls">
                                        <input value="{{$row->id_number}}" id="id_number" type="text" name="id_number" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input value="{{$row->email}}" id="email" type="text" name="email" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Phone Number</label>
                                    <div class="controls">
                                        <input value="{{$row->homephone}}" id="homephone" type="text" name="homephone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Handphone Number</label>
                                    <div class="controls">
                                        <input value="{{$row->handphone}}" id="handphone" type="text" name="handphone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Birthplace</label>
                                    <div class="controls">
                                        <input value="{{$row->birthplace}}" id="birthplace" type="text" name="birthplace" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Birthdate</label>
                                    <div class="controls">
                                        <input value="{{$row->birthdate}}" class="datepicker" data-date-format="yyyy-mm-dd" id="birthdate" type="text" name="birthdate" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <div class="controls">
                                        <input type="radio" @if($row->gender == 1) checked @endif value="1" name="gender" id="male"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="male">Male</label>
                                        <input type="radio" @if($row->gender == 2) checked @endif value="2" name="gender" id="female"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="female">Female</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Religion</label>
                                    <div class="controls">
                                        <select id="religion" name="religion">
                                            <option value="0" disabled selected>Select Religion</option>
                                            @foreach($religion as $val)
                                                <option @if($row->religion == $val) selected="selected" @endif value="{{$val}}">{{ucwords($val)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Job</label>
                                    <div class="controls">
                                        <input value="{{$row->job}}" id="job" type="text" name="job" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Address</label>
                                    <div class="controls">
                                        <textarea id="address" name="address">{{$row->address}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Country</label>
                                    <div class="controls">
                                        <select id="country_id" name="country_id">
                                            <option value="0" disabled selected>Choose Country</option>
                                            @foreach($country as $key => $val)
                                                <option @if($row->country_id == $val['country_id']) selected="selected" @endif value="{{$val['country_id']}}">{{$val['country_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="Save" />
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