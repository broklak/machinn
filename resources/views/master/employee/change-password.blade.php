@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Change Password</a> </div>
        <h1>Change Password</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Change Password</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("change-password")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">New Password</label>
                                    <div class="controls">
                                        <input id="name" required type="password" name="newpass" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Re-Type New Password</label>
                                    <div class="controls">
                                        <input id="name" required type="password" name="conpass" />
                                    </div>
                                </div>
                                <input type="hidden" name="submit" value="1">
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="Save" />
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