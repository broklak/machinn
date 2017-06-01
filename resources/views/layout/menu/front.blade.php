<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'front' && !isset($type)) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>Front Office</span></a>
    <ul>
        @if($menu['front-roomTransaction'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'room-transaction') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Room Transaction</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'room-transaction') style="display: block" @endif>
                    @if(\App\UserRole::checkAccess(6, 'create'))
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'checkin') class="active" @endif>
                            <a href="{{route('checkin.index')}}">Check In</a>
                        </li>
                    @endif
                    <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.edit') class="active" @endif>
                        <a href="{{route('booking.index')}}">Booking</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'room-number.view-room') class="active" @endif>
                        <a href="{{route('room-number.view-room')}}">Room View</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['guest'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'guest') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Guest</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'guest') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.inhouse' && !isset($paid)) class="active" @endif>
                        <a href="{{route('guest.inhouse')}}">In House Guest</a>
                    </li>
                    <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.edit') class="active" @endif>
                        <a href="{{route('guest.index')}}">List All Guest</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.statistic') class="active" @endif>
                        <a href="{{route('guest.statistic')}}">Guest Statistic</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.checkin') class="active" @endif>
                        <a href="{{route('guest.checkin')}}">Guest By Check In</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['front-info'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'info') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Info</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'info') style="display: block" @endif>
                    @if($menu['master-employee'])
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'staff.index') class="active" @endif>
                            <a href="{{route('staff.index')}}">Staff Contact</a>
                        </li>
                    @endif
                    @if($menu['logbook'])
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'logbook') class="active" @endif>
                            <a href="{{route('logbook.index')}}">Log Book</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if($menu['front-cashier'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'cashier') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Cashier</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'cashier') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName(2) == 'guest.inhouse' && isset($paid) && $paid == 1) class="active" @endif>
                        <a href="{{route('guest.inhouse')}}?paid=1">Guest Payment</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'transaction') class="active" @endif>
                        <a href="{{route('transaction.index')}}">Expense</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'pos') class="active" @endif>
                        <a href="{{route('pos.create')}}">Outlet Posting</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'report-front') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Report</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'report-front') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.report') class="active" @endif>
                        <a href="{{route('booking.report')}}">Booking Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.guest-bill') class="active" @endif>
                        <a href="{{route('report.guest-bill')}}">Guest Bill Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment') class="active" @endif>
                        <a href="{{route('report.down-payment')}}">Deposit Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.cash-credit') class="active" @endif>
                        <a href="{{route('report.cash-credit')}}">Cash and Credit Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.front-pos') class="active" @endif>
                        <a href="{{route('report.front-pos')}}">Outlet Posting Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.source') class="active" @endif>
                        <a href="{{route('report.source')}}">Business Source Report</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</li>