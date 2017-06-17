<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'master') open active @endif"> <a href="#">
  <i class="icon icon-th-list"></i> <span>@lang('module.master')</span></a>
    <ul>
        @if($menu['master-room'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'rooms') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.rooms')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'rooms') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-attribute') class="active" @endif>
                        <a href="{{route('room-attribute.index')}}">@lang('module.roomAttribute')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-rate-day-type') class="active" @endif>
                        <a href="{{route('room-rate-day-type.index')}}">@lang('module.rateDayType')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-type') class="active" @endif>
                        <a href="{{route('room-type.index')}}">@lang('module.roomType')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-number') class="active" @endif>
                        <a href="{{route('room-number.index')}}">@lang('module.roomNumber')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-plan') class="active" @endif>
                        <a href="{{route('room-plan.index')}}">@lang('module.roomPlan')</a>
                    </li>
                </ul>
            </li>

            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'banquet') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.banquet')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'banquet') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'banquet-event') class="active" @endif>
                        <a href="{{route('banquet-event.index')}}">@lang('module.banquetEvent')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'banquet') class="active" @endif>
                        <a href="{{route('banquet.index')}}">@lang('module.banquetTime')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['master-employee'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'employees') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.employee')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'employees') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'department') class="active" @endif>
                        <a href="{{route('department.index')}}">@lang('web.department')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-shift') class="active" @endif>
                        <a href="{{route('employee-shift.index')}}">@lang('module.employeeShift')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-status') class="active" @endif>
                        <a href="{{route('employee-status.index')}}">@lang('module.employeeStatus')</a>
                    </li>
                    @if($menu['setting'])
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee') class="active" @endif>
                            <a href="{{route('employee.index')}}">@lang('module.employeeList')</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if($menu['master-payment'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'cost') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.costIncome')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'cost') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'cost') class="active" @endif>
                        <a href="{{route('cost.index')}}">@lang('web.cost')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'income') class="active" @endif>
                        <a href="{{route('income.index')}}">@lang('web.income')</a>
                    </li>
                </ul>
            </li>
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'extracharge') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.extracharge')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'extracharge') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'extracharge-group') class="active" @endif>
                        <a href="{{route('extracharge-group.index')}}">@lang('module.extrachargeGroup')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'extracharge') class="active" @endif>
                        <a href="{{route('extracharge.index')}}">@lang('module.extracharge')</a>
                    </li>
                </ul>
            </li>
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'payment') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.payment')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'payment') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'bank') class="active" @endif>
                        <a href="{{route('bank.index')}}">@lang('module.bank')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'cash-account') class="active" @endif>
                        <a href="{{route('cash-account.index')}}">@lang('web.cashBankAccount')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'credit-card-type') class="active" @endif>
                        <a href="{{route('credit-card-type.index')}}">@lang('module.ccType')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'tax' && $parent_menu == 'payment') class="active" @endif>
                        <a href="{{route('tax.index')}}">@lang('web.tax')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'settlement') class="active" @endif>
                        <a href="{{route('settlement.index')}}">@lang('web.bookingPaymentDescriptionSettlement')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['master-partner'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'partner') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.businessPartner')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'partner') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'partner-group') class="active" @endif>
                        <a href="{{route('partner-group.index')}}">@lang('module.groupPartner')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'partner') class="active" @endif>
                        <a href="{{route('partner.index')}}">@lang('module.businessPartner')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact-group') class="active" @endif>
                        <a href="{{route('contact-group.index')}}">@lang('module.contactGroup')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact') class="active" @endif>
                        <a href="{{route('contact.index')}}">@lang('module.contact')</a>
                    </li>
                </ul>
            </li>
        @endif

        @if($menu['master-hotelProperty'])
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'location') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.location')</span></a>
               <ul @if(isset($parent_menu) && $parent_menu == 'location') style="display: block" @endif>
                   <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'country') class="active" @endif>
                       <a href="{{route('country.index')}}">@lang('module.country')</a>
                   </li>
                   <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'province') class="active" @endif>
                       <a href="{{route('province.index')}}">@lang('module.province')</a>
                   </li>
               </ul>
            </li>
            <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'property') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>@lang('module.property')</span></a>
                <ul @if(isset($parent_menu) && $parent_menu == 'property') style="display: block" @endif>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'property-attribute') class="active" @endif>
                        <a href="{{route('property-attribute.index')}}">@lang('module.propertyAttribute')</a>
                    </li>
                    <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'property-floor') class="active" @endif>
                        <a href="{{route('property-floor.index')}}">@lang('module.propertyFloor')</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</li>
