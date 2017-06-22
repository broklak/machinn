@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Hotel</a> <a href="#" class="current">@lang('master.changeHotelProfile')</a> </div>
        <h1>@lang('master.changeHotelProfile')</h1>
    </div>
    <div class="container-fluid"><hr>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('master.changeHotelProfile')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("update-hotel")}}" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.hotelLogo') *@lang('master.logoResolution') 220 X 75 Pixels</label>
                                    <div class="controls">
                                        <img style="width: 220px;height: 75px;" src="{{($row->logo == null) ? asset('img/matrix/no_image.png') : asset('storage/img/matrix/'.$row->logo) }}?v={{date('s')}}">
                                        <input type="file" name="logo" accept="image/*" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('master.hotelName')</label>
                                    <div class="controls">
                                        <input value="{{$row->name}}" id="last_name" type="text" name="name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.phone')</label>
                                    <div class="controls">
                                        <input value="{{$row->phone}}" id="homephone" type="text" name="phone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('master.fax')</label>
                                    <div class="controls">
                                        <input value="{{$row->fax}}" id="handphone" type="text" name="fax" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input value="{{$row->email}}" id="email" type="text" name="email" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.address')</label>
                                    <div class="controls">
                                        <textarea id="address" name="address">{{$row->address}}</textarea>
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
