<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'resto' || (isset($type) && $type == 'resto')) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>@lang('module.posResto')</span></a>
    <ul>

        @if($menu['resto-master'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'master-resto') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.master')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'master-resto') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'item') class="active" @endif>
                        <a href="{{route('item.index')}}">@lang('module.itemPrice')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'category') class="active" @endif>
                        <a href="{{route('category.index')}}">@lang('module.itemCategory')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'table') class="active" @endif>
                        <a href="{{route('table.index')}}">@lang('module.tables')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'tax') class="active" @endif>
                        <a href="{{route('pos.tax.index')}}">@lang('web.tax')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'stock') class="active" @endif>
                        <a href="{{route('item.stock')}}">@lang('module.stock')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['resto-transaction'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'pos-resto') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.transaction')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'pos-resto') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'pos') class="active" @endif>
                        <a href="{{route('resto.pos.create')}}">@lang('module.newTransaction')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'active') class="active" @endif>
                        <a href="{{route('resto.pos.active')}}">@lang('module.activeOrder')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'resto-report') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.report')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'resto-report') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'resto.report-sales') class="active" @endif>
                        <a href="{{route('resto.report-sales')}}">@lang('module.salesReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'resto.report-item') class="active" @endif>
                        <a href="{{route('resto.report-item')}}">@lang('module.stockReport')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['logbook'])
            <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'logbook') class="active" @endif>
                <a href="{{route('logbook.index')}}?type=resto">@lang('module.logBook')</a>
            </li>
        @endif
    </ul>
</li>
