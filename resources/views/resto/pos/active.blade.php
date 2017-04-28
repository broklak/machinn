@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = 'resto.pos'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Active Order</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-success" href="{{route("$route_name.create")}}">Add New Transaction</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="summary-td">
                                <th>ROOM / TABLE</th>
                                <th>ITEM</th>
                                <th>QTY</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="summary-td" colspan="5">Dine In</td>
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
                                                        <i class="icon icon-remove"></i> Set Not Delivered
                                                    </a>
                                                @else
                                                    <a href="{{route('resto.pos.set-delivery', ['id' => $val_detail->id, 'status' => 1])}}">
                                                        <i class="icon icon-check"></i> Set Delivered
                                                    </a>
                                                @endif
                                                <br />
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td class="summary-td" colspan="5">Room Service</td>
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
                                                            <i class="icon icon-remove"></i> Set Not Delivered
                                                        </a>
                                                    @else
                                                        <a href="{{route('resto.pos.set-delivery', ['id' => $val_detail->id, 'status' => 1])}}">
                                                            <i class="icon icon-check"></i> Set Delivered
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