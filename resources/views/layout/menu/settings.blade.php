<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'setting' || (isset($type) && $type == 'setting')) open active @endif">
    <a href="#"><i class="icon icon-th-list"></i> <span>@lang('module.setting')</span></a>
    <ul>
        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee') class="active" @endif>
            <a href="{{route('setting.employee.index')}}">@lang('module.userManagement')</a>
        </li>
        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-type') class="active" @endif>
            <a href="{{route('employee-type.index')}}">@lang('module.roleManagement')</a>
        </li>
    </ul>
</li>
