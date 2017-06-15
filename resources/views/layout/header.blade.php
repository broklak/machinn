<!--Header-part-->
<div id="header">
    <a href="#">
        <img style="height: 75px;width: 220px" src="{{(session('logo') == null) ? asset('img/matrix/no_image.png') : asset('storage/img/matrix/'.session('logo')) }}">
    </a>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
      <li class="dropdown">
          <a title="" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle" href="#"><i class="icon icon-caret-down"></i>
              <span class="text">@lang('web.chooseLanguage')</span></a>
          <ul class="dropdown-menu">
            <li @if((App::isLocale('en'))) style="background-color:#000" @endif><a @if((App::isLocale('en'))) style="color:#fff" @endif href="{{route('language', ['locale' => 'en'])}}">English</a></li>
            <li @if((App::isLocale('id'))) style="background-color:#000" @endif><a @if((App::isLocale('id'))) style="color:#fff" @endif href="{{route('language', ['locale' => 'id'])}}">Bahasa</a></li>
          </ul>
      </li>
        <li class=""><a id="show-notif" title="" href="javascript:void(0)"><i class="icon icon-bell"></i> <span class="text">Notification</span>
            <span class="label label-important" id="notif-num">0</span>
            </a></li>
        <li class="dropdown">
            <a title="" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle" href="#"><i class="icon icon-caret-down"></i>
                <span class="text">Welcome {{ucfirst($user['name'])}}</span></a>
            <ul class="dropdown-menu">
                <li><a href="{{route('change-password')}}"><i class="icon icon-lock"></i> Change Password</a></li>
                @if($menu['setting'])
                    <li><a href="{{route('profile')}}"><i class="icon icon-building"></i> Change Hotel Profile</a></li>
                @endif
            </ul>
        </li>
        <li class=""><a title="" href="{{url('/logout')}}"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
    </ul>
</div>
