<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        @if($menu['master'])
            @include('layout.menu.master')
        @endif

        @if($menu['front'])
            @include('layout.menu.front')
        @endif

        @if($menu['house'])
            @include('layout.menu.house')
        @endif

        @if($menu['resto'])
            @include('layout.menu.resto')
        @endif

        @if($menu['back'])
            @include('layout.menu.back')
        @endif

        @if($menu['setting'])
            @include('layout.menu.settings')
        @endif
    </ul>
</div>