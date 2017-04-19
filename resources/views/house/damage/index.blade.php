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
                        <h5>Damage Asset List</h5>
                        <div class="filter-data">
                            <form>
                                <input id="guest" name="asset_name" placeholder="Search by Asset Name" value="{{$asset_name}}" type="text" />
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
                                <th>Asset Name</th>
                                <th>Description</th>
                                <th>Room Number</th>
                                <th>Reported By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{$val->asset_name}}</td>
                                        <td>{{$val->description}}</td>
                                        <td>{{$val->room_number_id}}</td>
                                        <td>{{\App\User::getName($val->founder_employee_id)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a onclick="return confirm('{{$val->asset_name}} will be deleted, continue?')" href="{{route($route_name.'.delete', ['id' => $val->id])}}"><i class="icon icon-remove"></i> Delete</a></li>
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