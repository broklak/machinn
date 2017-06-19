@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.' : '' @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.guestStatistic')</a> </div>
        <h1>@lang('module.guestStatistic')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">@lang('web.chooseDateRange')</label>
                <div class="controls">
                    <form action="">
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" value="@lang('web.search')" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li @if($typeGender == 'gender') class="active" @endif><a href="{{route($route.'guest.statistic')}}">@lang('web.gender')</a></li>
                            <li @if($typeGender == 'age') class="active" @endif><a href="{{route($route.'guest.statistic')}}?type=age">@lang('web.age')</a></li>
                            <li @if($typeGender == 'religion') class="active" @endif><a href="{{route($route.'guest.statistic')}}?type=religion">@lang('web.religion')</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="gender" class="tab-pane active">
                            <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                                <h5>{{ucfirst($typeGender)}} Statistics</h5>
                            </div>
                            <div class="widget-content">
                                @if(count($rows) > 0)
                                    <div class="pie"></div>
                                @else
                                    <h3 class="text-center">@lang('msg.noData')</h3>
                                @endif
                            </div>
                        </div>
                        <div id="age" class="tab-pane">

                        </div>
                        <div id="religion" class="tab-pane">

                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection
