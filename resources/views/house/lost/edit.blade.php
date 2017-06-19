@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">@lang('module.lost')</a> <a href="#" class="current">@lang('web.add') @lang('module.lost')</a> </div>
        <h1>@lang('module.lost')</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">@lang('web.view') Data</a>
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
                            <h5>@lang('web.edit') @lang('module.lost')</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.date')</label>
                                    <div class="controls">
                                        <input id="date" required class="datepicker" value="{{$row->date}}" data-date-format="yyyy-mm-dd" type="text" name="date" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.itemName')</label>
                                    <div class="controls">
                                        <input id="item_name" required type="text" value="{{$row->item_name}}" name="item_name" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.color')</label>
                                    <div class="controls">
                                        <input id="item_color" type="text"  value="{{$row->item_color}}" name="item_color" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.itemValue')</label>
                                    <div class="controls">
                                        <input id="item_value" type="text" value="{{$row->item_value}}" name="item_value" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.placeMissing')</label>
                                    <div class="controls">
                                        <input id="place" type="text" value="{{$row->place}}" name="place" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.desc')</label>
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
                            <h5>@lang('web.reporterInformation')</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">@lang('web.name')</label>
                                    <div class="controls">
                                        <input id="guest_id" type="hidden" name="guest_id" value="{{$row->guest_id}}">
                                        <input id="report_name" value="{{$row->report_name}}" required type="text" name="report_name" />
                                        <a href="#modalFindGuest" data-toggle="modal" class="btn btn-inverse">@lang('web.findGuest')</a>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.address')</label>
                                    <div class="controls">
                                        <textarea id="report_address" name="report_address">{{$row->report_address}}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.phone')</label>
                                    <div class="controls">
                                        <input id="phone" type="text" value="{{$row->phone}}" name="phone" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">@lang('web.email')</label>
                                    <div class="controls">
                                        <input id="email" type="email" value="{{$row->email}}" name="email" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="@lang('web.save')">
            </div>
            {{ method_field('PUT') }}
        </form>
    </div>

    <div id="modalFindGuest" class="modal hide">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">×</button>
            <h3>@lang('web.findGuest')</h3>
        </div>
        <div class="modal-body">
            <form id="searchGuestForm" class="form-horizontal">
                {{csrf_field()}}
                <div id="form-search-guest" class="step">
                    <div class="control-group">
                        <label class="control-label">@lang('web.searchName')</label>
                        <div class="controls">
                            <input id="searchguest" name="query" type="text" />
                            <input type="submit" value="@lang('web.submitSearch')" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('web.name')</th>
                    <th>ID</th>
                    <th>@lang('web.action')</th>
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
                               id="guest-{{$val['guest_id']}}" class="btn btn-success chooseGuest">@lang('web.choose')</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
