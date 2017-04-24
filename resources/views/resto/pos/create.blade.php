@extends('layout.main')

@section('title', 'Home')

@section('content')
@php $route_name = 'resto.pos'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Create {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <a href="{{route($route_name.'.index')}}" class="btn btn-success">View Transaction</a>
        <div id="error_messages" style="margin-top: 20px">

        </div>
        <form id="form-pos" class="form-horizontal" action="{{route("$route_name.store")}}" method="post">
            <input type="hidden" name="type" value="1" id="saveType">
            {{csrf_field()}}
            <div class="row-fluid">
                <div class="span6">
                    @include('resto.pos.header-create')
                    @include('resto.pos.payment-create')
                </div>
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                            <h5>Item List</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">Search Menu</label>
                                    <div class="controls">
                                        <input id="menu" type="text" name="menu" list="menu-list" />
                                        <datalist id="menu-list">
                                            @foreach($item as $key => $val)
                                                <option data-id="{{$val->id}}" data-price="{{$val->cost_sales}}" value="{{$val->name}}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ITEM NAME</th>
                                        <th>PRICE</th>
                                        <th>QTY</th>
                                        <th>DISCOUNT</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="list-data">
                                    <tr>
                                        <td colspan="5" style="text-align: right;font-weight: bold;font-size: 18px">GRAND TOTAL : <span id="grand_total_text">IDR 0</span>
                                            <input type="hidden" name="grand_total" value="0" id="grand_total">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <input type="submit" class="btn btn-primary" style="display: block;width: 100%" value="SAVE AS DRAFT">
                </div>
                <div class="span6">
                    <a id="billedButton" class="btn btn-success" style="display: block;width: 100%">SAVE AS BILLED</a>
                </div>
            </div>
        </form>
    </div>

    @include('resto.pos.modal-guest')

@endsection