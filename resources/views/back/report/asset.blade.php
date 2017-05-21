@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.transaction' : 'transaction'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Asset Report</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                <div class="control-group">
                    <label class="control-label">Choose Asset Category</label>
                    <div class="controls">
                        <select name="category" onchange="this.form.submit()">
                            <option value="0">All Category</option>
                            <option @if($category == 1) selected @endif value="1">Furniture Hotel</option>
                            <option @if($category == 2) selected @endif value="2">Electronic</option>
                            <option @if($category == 3) selected @endif value="3">Kitchen Equipment</option>
                            <option @if($category == 4) selected @endif value="4">Others</option>
                        </select>
                    </div>
                </div>
            </form>
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
                                <th>Category</th>
                                <th>Purchase Date</th>
                                <th>Purchase Amount</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($asset) > 0)
                                @php $totalAmount = $totalQty = 0; @endphp
                                @foreach($asset as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->property_attribute_name}}</td>
                                        <td>{{\App\PropertyAttribute::categoryName($val->type)}}</td>
                                        <td>{{($val->purchase_date == null) ? date('j F Y', strtotime($val->created_at)) : date('j F Y', strtotime($val->purchase_date))}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->purchase_amount)}}</td>
                                        <td>{{$val->qty}}</td>
                                    </tr>
                                    @php $totalQty = $totalQty + $val->qty; @endphp
                                    @php $totalAmount = $totalAmount + $val->purchase_amount; @endphp
                                @endforeach
                                <tr>
                                    <td class="summary-td" colspan="3" style="text-align: right">TOTAL</td>
                                    <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($totalAmount)}}</td>
                                    <td class="summary-td">{{$totalQty}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" style="text-align: center">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection