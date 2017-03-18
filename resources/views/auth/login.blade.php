<!DOCTYPE html>
<html lang="en">

<head>
    <title>Matrix Admin</title><meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset("css") }}/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset("css") }}/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="{{ asset("css") }}/matrix-login.css" />
    <link href="{{asset('font-awesome')}}/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

</head>
<body>
<div id="loginbox">
    <form id="loginform" class="form-vertical" method="POST" action="{{ route('login') }}">
        {{csrf_field()}}
        <div class="control-group normal_text"> <h1>HOTEL ADMIN</h1></div>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Error!</strong> {{$error}}
                </div>
            @endforeach
        @endif

        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="username" placeholder="Username" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
            <span class="pull-right"><input type="submit" value="Login" class="btn btn-success"></span>
        </div>
    </form>
</div>

<script src="{{asset("js")}}/jquery.min.js"></script>
<script src="{{asset("js")}}/jquery.ui.custom.js"></script>
<script src="{{asset("js")}}/bootstrap.min.js"></script>
<script src="{{asset("js")}}/matrix.js"></script>
<script src="{{asset("js")}}/matrix.interface.js"></script>
<script src="{{asset("js")}}/matrix.popover.js"></script>
</body>

</html>
