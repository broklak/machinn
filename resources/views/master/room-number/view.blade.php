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
                <label class="control-label">Choose Date Range</label>
                <div class="controls">
                    <form>
                        <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                        <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="legend-status">
                <span class="vacant">&nbsp;</span><span class="legend-title">Vacant</span>
                <span class="occupied">&nbsp;</span><span class="legend-title">Occupied</span>
                <span class="guaranteed">&nbsp;</span><span class="legend-title">Guaranteed</span>
                <span class="tentative">&nbsp;</span><span class="legend-title">Tentative</span>
            </div>
        </div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <div style="overflow-x:auto;">
                            <table class="table table-bordered view-room">
                                <thead>
                                    <tr>
                                        <td>Room</td>
                                        @for ($i = 0; $i < $date_diff; $i++)
                                            <td @if(date('D', strtotime($start) + (86400 * $i)) == 'Sun' || date('D', strtotime($start) + (86400 * $i)) == 'Sat') class="red-date" @endif>
                                                {{date('d', strtotime($start) + (86400 * $i))}} {{date('M', strtotime($start) + (86400 * $i))}} <br />{{date('D', strtotime($start) + (86400 * $i))}}
                                            </td>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($room_type as $key_type => $val_type)
                                        <tr>
                                            <td class="room-type-name" colspan="{{$date_diff + 1}}">{{$val_type->room_type_name}}</td>
                                        </tr>
                                        @foreach(\App\RoomNumber::where('room_type_id', $val_type->room_type_id)->get() as $key_code => $val_code)
                                            <tr>
                                                <td>{{$val_code->room_number_code}}</td>
                                                @for ($i = 0; $i < $date_diff; $i++)
                                                    @php $day = date('Y-m-d', strtotime($start) + (86400 * $i)) @endphp
                                                    @if(isset($room[$val_code->room_number_id.':'.$day]))
                                                        <td class="{{\App\Helpers\GlobalHelper::getBookingRoomStatusColor($room[$val_code->room_number_id.':'.$day]->status)}}"></td>
                                                    @else
                                                        <td class="vacant"></td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection