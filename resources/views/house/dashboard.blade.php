@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('web.houseKeeping')</a> </div>
        <h1>@lang('web.houseKeeping')</h1>
    </div>
    <div class="container-fluid">
        <div class="legend-status">
            <span class="ooo"><i class="icon icon-check"></i></span><span class="legend-title">@lang('web.roomStatusReady')</span>
            <span class="ooo"><i class="icon icon-warning-sign"></i></span><span class="legend-title">@lang('web.roomStatusDirty')</span>
            <span class="ooo"><i class="icon icon-wrench"></i></span><span class="legend-title">@lang('web.roomStatusOut')</span>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <table style="position: relative" class="table table-bordered view-room">
                            <tbody id="listRoom" style="position: relative">
                                {!! $html !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
