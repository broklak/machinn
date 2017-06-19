@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.lost')</a> </div>
        <h1>@lang('module.lost')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') Data</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>@lang('module.lost')</h5>
                        <div class="filter-data">
                            <form>
                                <input id="guest" name="item_name" placeholder="@lang('web.searchName')" value="{{$item_name}}" type="text" />
                                <input type="submit" class="btn btn-primary" value="@lang('web.submitSearch')">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.date')</th>
                                <th>@lang('web.itemName')</th>
                                <th>@lang('web.color')</th>
                                <th>@lang('web.placeMissing')</th>
                                <th>@lang('web.name')</th>
                                <th>@lang('web.address')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{$val->item_name}}</td>
                                        <td>{{$val->item_color}}</td>
                                        <td>{{$val->place}}</td>
                                        <td>{{$val->report_name}}</td>
                                        <td>{{$val->report_address}}</td>
                                        <td>{{\App\Lost::getStatus($val->status, $val->updated_by)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button @if($val->status == 2) disabled @endif data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a></li>
                                                    <li><a onclick="return confirm('@lang('msg.confirmReturned', ['data' => $val->item_name])?')" href="{{route($route_name.'.change-status', ['id' => $val->id, 'status' => 2])}}"><i class="icon icon-check"></i> @lang('web.setReturned')</a></li>
                                                    <li><a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->item_name])')" href="{{route($route_name.'.delete', ['id' => $val->id])}}"><i class="icon icon-remove"></i> @lang('web.delete')</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" style="text-align: center">No Data Found</td>
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
