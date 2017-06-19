@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.stock')</a> </div>
        <h1>@lang('module.stock')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>@lang('module.itemPrice')</h5>
                        <div class="filter-data">
                            <form>
                                <input type="text" name="name" value="{{$item_name}}" placeholder="@lang('web.searchName')">
                                <select name="type">
                                    <option @if($item_type == 0) selected @endif value="0">@lang('web.allType')</option>
                                    <option @if($item_type == 1) selected @endif value="1">@lang('web.stockAvailable')</option>
                                    <option @if($item_type == 2) selected @endif value="2">@lang('web.outOfStock')</option>
                                </select>
                                <input type="submit" class="btn btn-primary" value="@lang('web.search')">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>@lang('web.category')</th>
                                <th>@lang('web.price')</th>
                                <th>@lang('module.stock')</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td width="25%">{{$val->name}}</td>
                                        <td width="25%">{{\App\PosCategory::getName($val->category_id)}}</td>
                                        <td width="15%">{{\App\Helpers\GlobalHelper::moneyFormat($val->cost_sales)}}</td>
                                        <td><input onfocus="formatStock($(this))" style="width: 30px" type="text" name="stock" id="stock-{{$val->id}}" value="{{$val->stock}}"></td>
                                        <td><button onclick="changeStock($(this))" data-id="{{$val->id}}"
                                                    data-name="{{$val->name}}" data-stock="{{$val->stock}}" class="btm btn-primary">@lang('web.updateStock')</button>
                                            <button onclick="setOutOfStock($(this))" data-id="{{$val->id}}"
                                                    data-name="{{$val->name}}" data-stock="{{$val->stock}}" class="btm btn-danger">@lang('web.setOut')</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center">@lang('web.noData')</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection
