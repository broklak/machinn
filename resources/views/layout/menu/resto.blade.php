<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'resto' || (isset($type) && $type == 'resto')) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>POS Resto</span></a>
    <ul>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'master-resto') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Master</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'master-resto') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'item') class="active" @endif>
                    <a href="{{route('item.index')}}">Item and Price</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'category') class="active" @endif>
                    <a href="{{route('category.index')}}">Category Item</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'table') class="active" @endif>
                    <a href="{{route('table.index')}}">Tables</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'tax') class="active" @endif>
                    <a href="{{route('pos.tax.index')}}">Tax</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'stock') class="active" @endif>
                    <a href="{{route('item.stock')}}">Stock</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'pos-resto') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                <span>Transaction</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'pos-resto') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'pos') class="active" @endif>
                    <a href="{{route('resto.pos.create')}}">New Transaction</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'active') class="active" @endif>
                    <a href="{{route('resto.pos.active')}}">Active Order</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'resto-report') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                <span>Report</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'resto-report') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'resto.report-sales') class="active" @endif>
                    <a href="{{route('resto.report-sales')}}">Sales Report</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'resto.report-item') class="active" @endif>
                    <a href="{{route('resto.report-item')}}">Item Report</a>
                </li>
            </ul>
        </li>
        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'logbook') class="active" @endif>
            <a href="{{route('logbook.index')}}?type=resto">Log Book</a>
        </li>
    </ul>
</li>