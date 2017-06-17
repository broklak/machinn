<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'front' && !isset($type)) open active @endif"> <a href="#"><i class="icon icon-th-list"></i>
  <span>@lang('module.frontOffice')</span></a>
    <ul>
        @if($menu['front-roomTransaction'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'room-transaction') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
              <span>@lang('module.roomTransaction')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'room-transaction') style="display: block" @endif>
                    @if(\App\UserRole::checkAccess(6, 'create'))
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'checkin') class="active" @endif>
                            <a href="{{route('checkin.index')}}">@lang('module.checkIn')</a>
                        </li>
                    @endif
                    <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.edit') class="active" @endif>
                        <a href="{{route('booking.index')}}">@lang('module.booking')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'room-number.view-room') class="active" @endif>
                        <a href="{{route('room-number.view-room')}}">@lang('module.roomView')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['guest'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'guest') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('web.guest')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'guest') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.inhouse' && !isset($paid)) class="active" @endif>
                        <a href="{{route('guest.inhouse')}}">@lang('module.inhouseGuest')</a>
                    </li>
                    <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.edit') class="active" @endif>
                        <a href="{{route('guest.index')}}">@lang('module.allGuest')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.statistic') class="active" @endif>
                        <a href="{{route('guest.statistic')}}">@lang('module.guestStatistic')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.checkin') class="active" @endif>
                        <a href="{{route('guest.checkin')}}">@lang('module.guestByCheckin')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['front-info'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'info') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.info')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'info') style="display: block" @endif>
                    @if($menu['master-employee'])
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'staff.index') class="active" @endif>
                            <a href="{{route('staff.index')}}">@lang('module.staffContact')</a>
                        </li>
                    @endif
                    @if($menu['logbook'])
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'logbook') class="active" @endif>
                            <a href="{{route('logbook.index')}}">@lang('module.logBook')</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if($menu['front-cashier'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'cashier') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.cashier')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'cashier') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName(2) == 'guest.inhouse' && isset($paid) && $paid == 1) class="active" @endif>
                        <a href="{{route('guest.inhouse')}}?paid=1">@lang('module.guestPayment')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'transaction') class="active" @endif>
                        <a href="{{route('transaction.index')}}">@lang('module.expense')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'pos') class="active" @endif>
                        <a href="{{route('pos.create')}}">@lang('module.outletPosting')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'report-front') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.report')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'report-front') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.report') class="active" @endif>
                        <a href="{{route('booking.report')}}">@lang('module.bookingReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.guest-bill') class="active" @endif>
                        <a href="{{route('report.guest-bill')}}">@lang('module.guestBillReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment') class="active" @endif>
                        <a href="{{route('report.down-payment')}}">@lang('module.depositReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.cash-credit') class="active" @endif>
                        <a href="{{route('report.cash-credit')}}">@lang('module.cashCreditReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.front-pos') class="active" @endif>
                        <a href="{{route('report.front-pos')}}">@lang('module.outletPostingReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.source') class="active" @endif>
                        <a href="{{route('report.source')}}">@lang('module.businessSourceReport')</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</li>
