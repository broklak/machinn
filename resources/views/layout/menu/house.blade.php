<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'housekeep' || (isset($type) && $type == 'housekeep')) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>House Keeping</span></a>
    <ul>
        @if($menu['dashboard'])
            <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'house') class="active" @endif>
                <a href="{{route('house.dashboard')}}">Dashboard</a>
            </li>
        @endif

        @if($menu['logbook'])
            <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'logbook') class="active" @endif>
                <a href="{{route('logbook.index')}}?type=housekeep">Log Book</a>
            </li>
        @endif

        @if($menu['house-lostFound'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'lostfound') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Lost and Found</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'lostfound') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'lost') class="active" @endif>
                        <a href="{{route('lost.index')}}">Lost Information</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'found') class="active" @endif>
                        <a href="{{route('found.index')}}">Found Information</a>
                    </li>
                </ul>
            </li>
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'asset') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Lost and Damage Asset</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'asset') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'damage' && !isset($lost)) class="active" @endif>
                        <a href="{{route('damage.index')}}">Damage Asset</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'damage' && isset($lost)) class="active" @endif>
                        <a href="{{route('damage.index')}}?lost=1">Lost Asset</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['house-booking'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'booking-house') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Booking</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'booking-house') style="display: block" @endif>
                    @if($menu['front-roomTransaction'])
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'booking') class="active" @endif>
                            <a href="{{route('booking.index')}}?type=housekeep">List Booking</a>
                        </li>
                    @endif

                    @if($menu['guest'])
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.inhouse' && !isset($paid)) class="active" @endif>
                            <a href="{{route('guest.inhouse')}}?type=housekeep">In House Guest</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</li>