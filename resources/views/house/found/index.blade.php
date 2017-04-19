@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New {{$master_module}}</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Found Item List</h5>
                        <div class="filter-data">
                            <form>
                                <input type="text" name="founder_name" value="{{$founder_name}}" placeholder="Search by Founder Name">
                                <input id="guest" name="item_name" placeholder="Search by Item Name" value="{{$item_name}}" type="text" />
                                <input type="submit" class="btn btn-primary" value="Search">
                            </form>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date Report</th>
                                <th>Item Name</th>
                                <th>Color</th>
                                <th>Missing Place</th>
                                <th>Founder Name</th>
                                <th>Status</th>
                                <th>Action</th>
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
                                        <td>{{$val->founder_name}}</td>
                                        <td>{{\App\Found::getStatus($val->status, $val->updated_by)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button @if($val->status == 2) disabled @endif data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a onclick="return confirm('{{$val->item_name}} will be set to returned, continue?')" href="{{route($route_name.'.change-status', ['id' => $val->id, 'status' => 2])}}"><i class="icon icon-check"></i> Set Returned</a></li>
                                                    <li><a onclick="return confirm('{{$val->item_name}} will be deleted, continue?')" href="{{route($route_name.'.delete', ['id' => $val->id])}}"><i class="icon icon-remove"></i> Delete</a></li>
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