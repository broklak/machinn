<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'back' || (isset($type) && $type == 'back')) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>Back Office</span></a>
    <ul>
        @if($menu['dashboard'])
            <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.dashboard') class="active" @endif>
                <a href="{{route('back.dashboard')}}">Dashboard</a>
            </li>
        @endif

        @if($menu['guest'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'guest-back') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Guest</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'guest') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.inhouse' && !isset($paid)) class="active" @endif>
                        <a href="{{route('back.guest.inhouse')}}">In House Guest</a>
                    </li>
                    <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.edit') class="active" @endif>
                        <a href="{{route('back.guest.index')}}">List All Guest</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.statistic') class="active" @endif>
                        <a href="{{route('back.guest.statistic')}}">Guest Statistic</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.checkin') class="active" @endif>
                        <a href="{{route('back.guest.checkin')}}">Guest By Check In</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'resto-report') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>Resto Report</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'resto-report') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report-sales') class="active" @endif>
                        <a href="{{route('back.report-sales')}}">Sales Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report-item') class="active" @endif>
                        <a href="{{route('back.report-item')}}">Item Report</a>
                    </li>
                </ul>
            </li>

            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'report-front') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Front Office Report</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'report-front') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.booking.report') class="active" @endif>
                        <a href="{{route('back.booking.report')}}">Booking Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.guest-bill') class="active" @endif>
                        <a href="{{route('back.report.guest-bill')}}">Guest Bill Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.down-payment') class="active" @endif>
                        <a href="{{route('back.report.down-payment')}}">Deposit Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.cash-credit') class="active" @endif>
                        <a href="{{route('back.report.cash-credit')}}">Cash and Credit Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.front-pos') class="active" @endif>
                        <a href="{{route('back.report.front-pos')}}">Outlet Posting Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.source') class="active" @endif>
                        <a href="{{route('back.report.source')}}">Business Source Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.arrival') class="active" @endif>
                        <a href="{{route('back.report.arrival')}}">Actual Arrival - Departure</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.occupied') class="active" @endif>
                        <a href="{{route('back.report.occupied')}}">Actual Room Occupied</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.outstanding') class="active" @endif>
                        <a href="{{route('back.report.outstanding')}}">Oustanding Bill</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.void') class="active" @endif>
                        <a href="{{route('back.report.void')}}">Booking Cancel History</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['back-audit'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'night-audit') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>Night Audit</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'night-audit') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.night.room') class="active" @endif>
                        <a href="{{route('back.night.room')}}">Room Transaction</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.night.outlet') class="active" @endif>
                        <a href="{{route('back.night.outlet')}}">Outlet Transaction</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['back-accountPayable'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'invoice') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>Account Payable</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'invoice') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'invoice') class="active" @endif>
                        <a href="{{route('invoice.index')}}">Invoice</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'invoice-payment') class="active" @endif>
                        <a href="{{route('invoice-payment.index')}}">Invoice Payment</a>
                    </li>
                </ul>
            </li>

            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'account-receivable') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>Account Receivable</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'account-receivable') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'account-receivable.index') class="active" @endif>
                        <a href="{{route('account-receivable.index')}}">List</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'back-income') class="active" @endif>
                        <a href="{{route('back-income.index')}}?type=2&parent=acc">Account Receivable Income</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['back-transaction'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'back-transaction') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>Transaction</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'back-transaction') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'mutation') class="active" @endif>
                        <a href="{{route('mutation.index')}}">Cash and Bank Transfer</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'back-income') class="active" @endif>
                        <a href="{{route('back-income.index')}}">Income</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'transaction') class="active" @endif>
                        <a href="{{route('back.transaction.index')}}">Expense</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'back-report') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>Report</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'back-report') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.cash') class="active" @endif>
                        <a href="{{route('back.report.cash')}}">Cash and Bank Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.profit') class="active" @endif>
                        <a href="{{route('back.report.profit')}}">Profit - Loss Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.expense') class="active" @endif>
                        <a href="{{route('back.report.expense')}}">Expense Report</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.asset') class="active" @endif>
                        <a href="{{route('back.report.asset')}}">Asset Report</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</li>