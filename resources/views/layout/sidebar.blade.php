<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        @include('layout.menu.master')

        @if($user['department_id'] == 1 || $user['employee_type_id'] == 1)
            @include('layout.menu.front')
        @endif

        @if($user['department_id'] == 4 || $user['employee_type_id'] == 1)
            @include('layout.menu.house')
        @endif

        @if($user['department_id'] == 3 || $user['employee_type_id'] == 1)
            @include('layout.menu.resto')
        @endif

        @if($user['department_id'] == 2 || $user['employee_type_id'] == 1)
            @include('layout.menu.back')
        @endif
    </ul>
</div>