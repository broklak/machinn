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
                        <input value="{{$name}}" id="name" type="text" name="name" />
                        <select name="department">
                            <option value="0">All Department</option>
                            @foreach($department as $key => $val)
                                <option @if($dept == $val->department_id) selected @endif value="{{$val->department_id}}">{{$val->department_name}}</option>
                            @endforeach
                        </select>
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Handphone Number</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->name}}</td>
                                        <td>{{$model->getDepartmentName($val->department_id)}}</td>
                                        <td>{{$val->phone}}</td>
                                        <td>{{$val->email}}</td>
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