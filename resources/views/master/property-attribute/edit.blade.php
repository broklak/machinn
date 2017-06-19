@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.propertyAttribute')</a> <a href="#" class="current">@lang('web.edit') @lang('module.propertyAttribute')</a> </div>
        <h1>@lang('module.propertyAttribute')</h1>
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
                        <h5>@lang('web.edit') @lang('module.propertyAttribute')</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->property_attribute_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('master.propertyAttributeName')</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->property_attribute_name}}" name="property_attribute_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.category')</label>
                                    <div class="controls">
                                        <select name="type">
                                            <option @if($row->type == 1) selected @endif value="1">@lang('web.propertyCategoryFurniture')</option>
                                            <option @if($row->type == 2) selected @endif value="2">@lang('web.propertyCategoryElectronic')</option>
                                            <option @if($row->type == 3) selected @endif value="3">@lang('web.propertyCategoryKitchen')</option>
                                            <option @if($row->type == 4) selected @endif value="4">@lang('web.others')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.purchaseDate')</label>
                                    <div class="controls">
                                        <input value="{{$row->purchase_date}}" id="purchase_date" data-date-format="yyyy-mm-dd" class="datepicker" required type="text" name="purchase_date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('master.purchaseAmount')</label>
                                    <div class="controls">
                                        <input value="{{$row->purchase_amount}}" id="purchase_amount" required type="number" name="purchase_amount" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.qty')</label>
                                    <div class="controls">
                                        <input  value="{{$row->qty}}" id="qty" required type="number" name="qty" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="@lang('web.save')" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
