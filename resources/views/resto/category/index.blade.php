@extends('layout.main')

@section('title', 'Home')

@section('content')

<div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    <h1>@lang('module.itemCategory')</h1>
</div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') Data</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>@lang('module.itemCategory')</h5>
                        <div class="filter-data">
                            <form>
                                <input type="text" name="name" value="{{$category_name}}" placeholder="@lang('web.searchName')">
                                <select name="type">
                                    <option @if($category_type == 0) selected @endif value="0">@lang('web.allType')</option>
                                    <option @if($category_type == 1) selected @endif value="1">@lang('web.menuTypeFood')</option>
                                    <option @if($category_type == 2) selected @endif value="2">@lang('web.menuTypeBeverage')</option>
                                </select>
                                <input type="submit" class="btn btn-primary" value="@lang('web.submitSearch')">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>@lang('web.desc')</th>
                                <th>@lang('web.discount')</th>
                                <th>@lang('web.type')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->desc}}</td>
                                        <td>{{$val->discount}}</td>
                                        <td>{{\App\PosCategory::getTypeName($val->type)}}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->status)!!}</td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->name]) ')"
                                               class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center">@lang('msg.noData')</td>
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
