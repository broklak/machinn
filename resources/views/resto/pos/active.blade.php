@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = 'resto.pos'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.activeOrder')</a> </div>
        <h1>@lang('module.activeOrder')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-success" href="{{route("$route_name.create")}}">@lang('web.addButton') @lang('module.transaction')</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="summary-td">
                                <th>{{strtoupper(__('module.roomNumber'))}} / {{strtoupper(__('module.tables'))}}</th>
                                <th>{{strtoupper(__('web.itemMenu'))}}</th>
                                <th>{{strtoupper(__('web.qty'))}}</th>
                                <th>STATUS</th>
                                <th>{{strtoupper(__('web.action'))}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="summary-td" colspan="5">@lang('web.deliveryTypeDine')</td>
                                </tr>
                                @foreach($dine as $key => $val)
                                    @if($detail = \App\OutletTransactionDetail::where('transaction_id', $val->transaction_id)->get())
                                    <tr>
                                        <td>Table {{\App\PosTable::getName($val->table_id)}}</td>
                                        <td>
                                            @foreach($detail as $key_detail => $val_detail)
                                                {{\App\PosItem::getName($val_detail->extracharge_id)}}<br />
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($detail as $key_detail => $val_detail)
                                                {{$val_detail->qty}}<br />
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($detail as $key_detail => $val_detail)
                                                {!!  \App\OutletTransactionDetail::getDeliveryStatus($val_detail->delivery_status)!!}
                                                <br />
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($detail as $key_detail => $val_detail)
                                                @if($val_detail->delivery_status == 1)
                                                    <a href="{{route('resto.pos.set-delivery', ['id' => $val_detail->id, 'status' => 0])}}">
                                                        <i class="icon icon-remove"></i> @lang('web.setNotDelivered')
                                                    </a>
                                                @else
                                                    <a href="{{route('resto.pos.set-delivery', ['id' => $val_detail->id, 'status' => 1])}}">
                                                        <i class="icon icon-check"></i> @lang('web.setDelivered')
                                                    </a>
                                                @endif
                                                <br />
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td class="summary-td" colspan="5">@lang('web.deliveryTypeRoom')</td>
                                </tr>
                                @foreach($room as $key => $val)
                                    @if($detail = \App\OutletTransactionDetail::where('transaction_id', $val->transaction_id)->get())
                                        <tr>
                                            <td>Room {{\App\RoomNumber::getCode($val->room_id)}}</td>
                                            <td>
                                                @foreach($detail as $key_detail => $val_detail)
                                                    {{\App\PosItem::getName($val_detail->extracharge_id)}}<br />
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($detail as $key_detail => $val_detail)
                                                    {{$val_detail->qty}}<br />
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($detail as $key_detail => $val_detail)
                                                    {!!  \App\OutletTransactionDetail::getDeliveryStatus($val_detail->delivery_status)!!}
                                                    <br />
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($detail as $key_detail => $val_detail)
                                                    @if($val_detail->delivery_status == 1)
                                                        <a href="{{route('resto.pos.set-delivery', ['id' => $val_detail->id, 'status' => 0])}}">
                                                            <i class="icon icon-remove"></i> @lang('web.setNotDelivered')
                                                        </a>
                                                    @else
                                                        <a href="{{route('resto.pos.set-delivery', ['id' => $val_detail->id, 'status' => 1])}}">
                                                            <i class="icon icon-check"></i> @lang('web.setDelivered')
                                                        </a>
                                                    @endif
                                                    <br />
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
