<li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'master') open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>Master</span></a>
    <ul>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'rooms') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Rooms</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'rooms') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-attribute') class="active" @endif>
                    <a href="{{route('room-attribute.index')}}">Room Attribute</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-rate-day-type') class="active" @endif>
                    <a href="{{route('room-rate-day-type.index')}}">Room Rate Day Type</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-type') class="active" @endif>
                    <a href="{{route('room-type.index')}}">Room Type</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-number') class="active" @endif>
                    <a href="{{route('room-number.index')}}">Room Number</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-plan') class="active" @endif>
                    <a href="{{route('room-plan.index')}}">Room Plan</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'banquet') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Banquet</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'banquet') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'banquet-event') class="active" @endif>
                    <a href="{{route('banquet-event.index')}}">Banquet Event</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'banquet') class="active" @endif>
                    <a href="{{route('banquet.index')}}">Banquet Time</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'employees') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Employees</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'employees') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'department') class="active" @endif>
                    <a href="{{route('department.index')}}">Department</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-shift') class="active" @endif>
                    <a href="{{route('employee-shift.index')}}">Employee Shift</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-status') class="active" @endif>
                    <a href="{{route('employee-status.index')}}">Employee Status</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee') class="active" @endif>
                    <a href="{{route('employee.index')}}">Employee</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'cost') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Cost and Income</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'cost') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'cost') class="active" @endif>
                    <a href="{{route('cost.index')}}">Cost</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'income') class="active" @endif>
                    <a href="{{route('income.index')}}">Income</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'extracharge') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Extracharge</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'extracharge') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'extracharge-group') class="active" @endif>
                    <a href="{{route('extracharge-group.index')}}">Extracharge Group</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'extracharge') class="active" @endif>
                    <a href="{{route('extracharge.index')}}">Extracharge</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'payment') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Payment</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'payment') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'bank') class="active" @endif>
                    <a href="{{route('bank.index')}}">Bank</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'cash-account') class="active" @endif>
                    <a href="{{route('cash-account.index')}}">Cash and Bank Account</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'credit-card-type') class="active" @endif>
                    <a href="{{route('credit-card-type.index')}}">Credit Card Type</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'tax' && $parent_menu == 'payment') class="active" @endif>
                    <a href="{{route('tax.index')}}">Tax</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'settlement') class="active" @endif>
                    <a href="{{route('settlement.index')}}">Settlement</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'location') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Location</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'location') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'country') class="active" @endif>
                    <a href="{{route('country.index')}}">Country</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'province') class="active" @endif>
                    <a href="{{route('province.index')}}">Province</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'partner') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Business Partner</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'partner') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'partner-group') class="active" @endif>
                    <a href="{{route('partner-group.index')}}">Partner Group</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'partner') class="active" @endif>
                    <a href="{{route('partner.index')}}">Partner</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact-group') class="active" @endif>
                    <a href="{{route('contact-group.index')}}">Contact Group</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact') class="active" @endif>
                    <a href="{{route('contact.index')}}">Contact</a>
                </li>
            </ul>
        </li>
        <li class="submenu2 @if(isset($parent_menu) && $parent_menu == 'property') open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>Property</span></a>
            <ul @if(isset($parent_menu) && $parent_menu == 'property') style="display: block" @endif>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'property-attribute') class="active" @endif>
                    <a href="{{route('property-attribute.index')}}">Property Attribute</a>
                </li>
                <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'property-floor') class="active" @endif>
                    <a href="{{route('property-floor.index')}}">Property Floor</a>
                </li>
            </ul>
        </li>
    </ul>
</li>