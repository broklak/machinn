@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <form>
                        <select name="status">
                            <option @if($filter['status'] == 0) selected @endif value="0">All Status</option>
                            <option @if($filter['status'] == 1) selected @endif value="1">Aproved</option>
                            <option @if($filter['status'] == 2) selected @endif value="2">Unapproved</option>
                        </select>
                        <input value="{{$filter['start']}}" id="checkin" type="text" name="start" /> TO
                        <input value="{{$filter['end']}}" id="checkout" type="text" name="end" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New {{$master_module}}</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cost Type</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{\App\Cost::getCostName($val->cost_id)}}</td>
                                        <td>{{$val->desc}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->amount)}}</td>
                                        <td>{{\App\FrontExpenses::getStatusName($val->status)}}</td>
                                        <td>
                                            @if($val->status != 1)
                                                <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit">
                                                    <i class="icon-pencil" aria-hidden="true"></i> Edit
                                                </a>
                                            @endif
                                            <div class="btn-group">
                                                <button @if($val->status == 1) disabled @endif data-toggle="dropdown" class="btn dropdown-toggle">Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if($val->status != 1)
                                                        <li><a href="{{route($route_name.'.change-status', ['id' => $val->id, 'status' => 1])}}"><i class="icon-check"></i>Approve</a></li>
                                                        <li><a href="{{route($route_name.'.change-status', ['id' => $val->id, 'status' => 3])}}"><i class="icon-remove"></i>Delete</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center">No Data Found</td>
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