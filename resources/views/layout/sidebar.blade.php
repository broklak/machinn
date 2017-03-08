<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        @foreach($menu as $key => $val)
            <li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == $key) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>{{ucfirst($key)}}</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
                <ul>
                    @foreach($val as $child)
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == $child) class="active" @endif><a href="{{route($child.'.index')}}">{{ucwords(str_replace('-', ' ',$child))}}</a></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>