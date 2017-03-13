@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <form method="post" action="{{route($route_name.'.store')}}">
                            {{csrf_field()}}
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Days</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows) > 0)
                                    @foreach($rows as $val)
                                        <tr class="odd gradeX">
                                            <td>{{$val->room_rate_day_type_name}}</td>
                                            <td>
                                                @php $x=0; @endphp
                                                @foreach($days as $val_day)
                                                    @php $x++; @endphp
                                                    <input id="{{$val->room_rate_day_type_name}}-{{$val_day}}" @if(stristr($val->room_rate_day_type_list, strtolower($val_day))) checked="checked" @endif type="checkbox" name="{{$val->room_rate_day_type_id}}-{{$x}}"><label for="{{$val->room_rate_day_type_name}}-{{$val_day}}" style="display: inline-table;vertical-align: sub;margin-left: 7px">{{$val_day}}</label><br />
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                <tr>
                                    <td style="text-align: center" colspan="2"><input class="btn btn-primary" type="submit" value="Save" /></td>
                                </tr>
                                @else
                                    <tr>
                                        <td colspan="3" style="text-align: center">No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection