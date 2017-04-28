@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <div class="legend-status">
            <span class="ooo"><i class="icon icon-check"></i></span><span class="legend-title">Ready</span>
            <span class="ooo"><i class="icon icon-warning-sign"></i></span><span class="legend-title">Dirty</span>
            <span class="ooo"><i class="icon icon-wrench"></i></span><span class="legend-title">Out of Order</span>
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