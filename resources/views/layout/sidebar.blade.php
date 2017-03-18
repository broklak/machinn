<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        @foreach($menu as $keyModule => $valModule)
            <li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == strtolower($valModule['module_name'])) open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>{{ucfirst($valModule['module_name'])}}</span></a>
                <ul>
                    @if(isset($valModule['submodule']))
                        @foreach($valModule['submodule'] as $keySubmodule => $valSubmodule)
                            @php $submoduleActive = false; @endphp
                            <li class="submenu2 @if($submoduleActive) open @endif"><a href="#"><i class="icon icon-list-alt"></i> <span>{{$valSubmodule['submodule_name']}}</span></a>
                                <ul @if(in_array(\Illuminate\Support\Facades\Request::segment(2), array_column($valSubmodule['class'], 'class_name'))) style="display: block" @endif>
                                    @foreach($valSubmodule['class'] as $keyClass => $valClass)
                                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == $valClass['class_name']) class="active" @endif>
                                            <a href="{{route($valClass['class_name'].'.index')}}">{{ucwords(str_replace('-', ' ',$valClass['class_name']))}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        @endforeach
    </ul>
</div>