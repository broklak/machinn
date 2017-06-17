<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'back' || (isset($type) && $type == 'back')) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>Back Office</span></a>
    <ul>
        @if($menu['dashboard'])
            <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.dashboard') class="active" @endif>
                <a href="{{route('back.dashboard')}}">@lang('module.dashboard')</a>
            </li>
        @endif

        @if($menu['guest'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'guest-back') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('web.guest')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'guest') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.inhouse' && !isset($paid)) class="active" @endif>
                        <a href="{{route('back.guest.inhouse')}}">@lang('module.inhouseGuest')</a>
                    </li>
                    <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.edit') class="active" @endif>
                        <a href="{{route('back.guest.index')}}">@lang('module.allGuest')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.statistic') class="active" @endif>
                        <a href="{{route('back.guest.statistic')}}">@lang('module.guestStatistic')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.guest.checkin') class="active" @endif>
                        <a href="{{route('back.guest.checkin')}}">@lang('module.guestByCheckin')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'resto-report') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.restoReport')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'resto-report') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report-sales') class="active" @endif>
                        <a href="{{route('back.report-sales')}}">@lang('module.salesReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report-item') class="active" @endif>
                        <a href="{{route('back.report-item')}}">@lang('module.stockReport')</a>
                    </li>
                </ul>
            </li>

            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'report-front') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.frontOfficeReport')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'report-front') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.booking.report') class="active" @endif>
                        <a href="{{route('back.booking.report')}}">@lang('module.bookingReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.guest-bill') class="active" @endif>
                        <a href="{{route('back.report.guest-bill')}}">@lang('module.guestBillReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.down-payment') class="active" @endif>
                        <a href="{{route('back.report.down-payment')}}">@lang('module.depositReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.cash-credit') class="active" @endif>
                        <a href="{{route('back.report.cash-credit')}}">@lang('module.cashCreditReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.front-pos') class="active" @endif>
                        <a href="{{route('back.report.front-pos')}}">@lang('module.outletPostingReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.source') class="active" @endif>
                        <a href="{{route('back.report.source')}}">@lang('module.businessSourceReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.arrival') class="active" @endif>
                        <a href="{{route('back.report.arrival')}}">@lang('module.actualArrivalReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.occupied') class="active" @endif>
                        <a href="{{route('back.report.occupied')}}">@lang('module.actualRoomOccupied')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.outstanding') class="active" @endif>
                        <a href="{{route('back.report.outstanding')}}">@lang('module.outstandingBill')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.void') class="active" @endif>
                        <a href="{{route('back.report.void')}}">@lang('module.bookingCancelHistory')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['back-audit'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'night-audit') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.nightAudit')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'night-audit') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.night.room') class="active" @endif>
                        <a href="{{route('back.night.room')}}">@lang('module.roomTransaction')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.night.outlet') class="active" @endif>
                        <a href="{{route('back.night.outlet')}}">@lang('module.outletTransaction')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['back-accountPayable'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'invoice') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.accountPayable')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'invoice') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'invoice') class="active" @endif>
                        <a href="{{route('invoice.index')}}">@lang('module.invoice')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'invoice-payment') class="active" @endif>
                        <a href="{{route('invoice-payment.index')}}">@lang('module.invoicePayment')</a>
                    </li>
                </ul>
            </li>

            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'account-receivable') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.accountReceivable')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'account-receivable') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'account-receivable.index') class="active" @endif>
                        <a href="{{route('account-receivable.index')}}">@lang('module.listAccountReceivable')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'back-income') class="active" @endif>
                        <a href="{{route('back-income.index')}}?type=2&parent=acc">@lang('module.incomeAccountReceivable')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['back-transaction'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'back-transaction') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.transaction')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'back-transaction') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'mutation') class="active" @endif>
                        <a href="{{route('mutation.index')}}">@lang('module.cashBankTransfer')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'back-income') class="active" @endif>
                        <a href="{{route('back-income.index')}}">@lang('module.income')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'transaction') class="active" @endif>
                        <a href="{{route('back.transaction.index')}}">@lang('module.expense')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['report'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'back-report') open @endif"><a href="#"><i class="icon icon-list-alt"></i>
                    <span>@lang('module.report')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'back-report') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.cash') class="active" @endif>
                        <a href="{{route('back.report.cash')}}">@lang('module.cashReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.profit') class="active" @endif>
                        <a href="{{route('back.report.profit')}}">@lang('module.profitReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.expense') class="active" @endif>
                        <a href="{{route('back.report.expense')}}">@lang('module.expenseReport')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'back.report.asset') class="active" @endif>
                        <a href="{{route('back.report.asset')}}">@lang('module.assetReport')</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</li>
