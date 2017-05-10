@extends('layout.main')

@section('title', 'Home')

@section('content')

    @php $route = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'guest.' : '' @endphp

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route($route_name.'.'.$route.'create')}}">Add New {{$master_module}}</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Gender</th>
                                <th>Handphone Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->first_name}} {{$val->last_name}}</td>
                                        <td>{{$val->id_number}} ({{\App\Guest::getIdType($val->id_type)}})</td>
                                        <td>@if($val->gender == 1) Male @else Female @endif</td>
                                        <td>{{$val->handphone}}</td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route($route_name.'.'.$route.'edit', ['id' => $val->guest_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                            <a onclick="return confirm('You will delete {{$val->first_name.' '.$val->last_name}}, continue? ')"
                                               class="delete-link" style="margin-right: 20px" href="{{route($route_name.'.'.$route.'delete', ['id' => $val->guest_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" style="text-align: center">No Data Found</td>
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