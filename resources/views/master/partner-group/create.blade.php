@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.groupPartner')</a> <a href="#" class="current">@lang('web.add') @lang('module.groupPartner')</a> </div>
        <h1>@lang('module.groupPartner')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>@lang('web.add') @lang('module.groupPartner')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('module.groupPartner')</label>
                                    <div class="controls">
                                        <input id="name" required type="text" name="partner_group_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">@lang('master.receiveBookingPayment')</label>
                                <div class="controls">
                                    <input type="radio" value="0" name="paid" id="no"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="no">@lang('web.no')</label>
                                    <input type="radio" value="1" name="paid" id="yes"><label style="display: inline-table;vertical-align: sub;margin: 0 10px" for="yes">@lang('web.yes')</label>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
