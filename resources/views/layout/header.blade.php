<!--Header-part-->
<div id="header">
    <h1><a href="dashboard.html">Hotel Admin</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li class="dropdown">
            <a title="" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle" href="#"><i class="icon icon-caret-down"></i>
                <span class="text">Welcome {{ucfirst($user['name'])}}</span></a>
            <ul class="dropdown-menu">
                <li><a href="{{route('change-password')}}"><i class="icon icon-lock"></i> Change Password</a></li>
            </ul>
        </li>
        <li class=""><a title="" href="{{url('/logout')}}"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
    </ul>
</div>