@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Create {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->id])}}" method="post">
            {{csrf_field()}}
            <div class="row-fluid">
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Item Information</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">Date Lost</label>
                                    <div class="controls">
                                        <input id="date" required class="datepicker" value="{{$row->date}}" data-date-format="yyyy-mm-dd" type="text" name="date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Item Name</label>
                                    <div class="controls">
                                        <input id="item_name" required type="text" value="{{$row->item_name}}" name="item_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Color</label>
                                    <div class="controls">
                                        <input id="item_color" type="text"  value="{{$row->item_color}}" name="item_color" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Item Value</label>
                                    <div class="controls">
                                        <input id="item_value" type="text" value="{{$row->item_value}}" name="item_value" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Place Missing</label>
                                    <div class="controls">
                                        <input id="place" type="text" value="{{$row->place}}" name="place" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="description">{{$row->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Reporter Information</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">Name</label>
                                    <div class="controls">
                                        <input id="guest_id" type="hidden" name="guest_id" value="{{$row->guest_id}}">
                                        <input id="report_name" value="{{$row->report_name}}" required type="text" name="report_name" />
                                        <a href="#modalFindGuest" data-toggle="modal" class="btn btn-inverse">Find Guest</a>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Address</label>
                                    <div class="controls">
                                        <textarea id="report_address" name="report_address">{{$row->report_address}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Phone</label>
                                    <div class="controls">
                                        <input id="phone" type="text" value="{{$row->phone}}" name="phone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                        <input id="email" type="email" value="{{$row->email}}" name="email" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE">
            </div>
            {{ method_field('PUT') }}
        </form>
    </div>

    <div id="modalFindGuest" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>Find Guest</h3>
        </div>
        <div class="modal-body">
            <form id="searchGuestForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">Filter Guest By Name or ID</label>
                        <div class="controls">
                            <input id="searchguest" name="query" type="text" />
                            <input type="submit" value="Search" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="listGuest">
                @foreach($guest as $key => $val)
                    <tr class="{{($val['guest_id'] % 2 == 1) ? 'odd' : 'even'}} gradeX">
                        <td>{{$val['first_name'].' '.$val['last_name']}}</td>
                        <td>{{$val['id_number']}} ({{$guestModel->getIdTypeName($val['id_type'])}})</td>
                        <td><a data-dismiss="modal" data-firstname="{{$val['first_name']}}" data-lastname="{{$val['last_name']}}" data-guesttype="{{$val['type']}}"
                               data-idtype="{{$val['id_type']}}" data-idnumber="{{$val['id_number']}}" data-id="{{$val['guest_id']}}" data-email="{{$val['email']}}" data-birthdate="{{$val['birthdate']}}"
                               data-religion="{{$val['religion']}}" data-gender="{{$val['gender']}}" data-job="{{$val['job']}}" data-birthplace="{{$val['birthplace']}}"
                               data-address="{{$val['address']}}" data-countryid="{{$val['country_id']}}" data-provinceid="{{$val['province_id']}}"
                               data-zipcode="{{$val['zipcode']}}" data-homephone="{{$val['homephone']}}" data-handphone="{{$val['handphone']}}" data-guesttitle="{{$val['title']}}"
                               id="guest-{{$val['guest_id']}}" class="btn btn-success chooseGuest">Choose</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection