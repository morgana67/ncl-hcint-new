@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.' Order')

@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-basket"></i> {{ __('voyager::generic.viewing') }} Order
        <a href="{{ route('admin.orders.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Order</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        <div class="col-md-6" style="font-size: 15px">

                            <table class="table" style="margin-top: 30px">
                                <tbody>
                                    <tr>
                                        <td>Name:</td>
                                        <td >{{$order->firstName.' '.$order->lastName}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{$order->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td>{{$order->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth:</td>
                                        <td>{{$order->dob ? \Carbon\Carbon::createFromFormat('Y-m-d',$order->dob)->format('M. jS, Y') : ""}}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender:</td>
                                        <td>{{$order->gender ? ($order->gender == 'm' ? 'Male' : 'Female') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td>{{$order->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address 2:</td>
                                        <td>{{$order->address2}}</td>
                                    </tr>
                                    <tr>
                                        <td>County:</td>
                                        <td>{{$order->country->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>State:</td>
                                        <td>{{$order->state}}</td>
                                    </tr>
                                    <tr>
                                        <td>City:</td>
                                        <td>{{$order->city}}</td>
                                    </tr>
                                    <tr>
                                        <td>Zip:</td>
                                        <td>{{$order->zip}}</td>
                                    </tr>
                                    <tr>
                                        <td>Message:</td>
                                        <td>{{$order->message}}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Type:</td>
                                        <td>{{$order->paymentType}}</td>
                                    </tr>
                                    <tr>
                                        <td>Order Status:</td>
                                        <td>
                                            <form method="POST" action="{{route('admin.orders.updateOrderStatus',['id' => $order->id])}}" id="formOrderStatus">
                                                @csrf
                                                <select name="orderStatus" id="orderStatus" >
                                                    <option value="pending" {{$order->orderStatus == 'pending' ? 'selected' : ''}}>Pending</option>
                                                    <option value="shipped" {{$order->orderStatus == 'shipped' ? 'selected' : ''}}>Shipped</option>
                                                    <option value="refunded" {{$order->orderStatus == 'refunded' ? 'selected' : ''}}>Refunded</option>
                                                    <option value="cancelled" {{$order->orderStatus == 'cancelled' ? 'selected' : ''}}>Cancelled</option>
                                                    <option value="completed" {{$order->orderStatus == 'completed' ? 'selected' : ''}}>Completed</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payment Status:</td>
                                        <td>
                                            <form method="POST" action="{{route('admin.orders.updatePaymentStatus',['id' => $order->id])}}" id="formPaymentStatus">
                                                @csrf
                                                <select name="paymentStatus" id="paymentStatus" >
                                                    <option value="processing" {{$order->paymentStatus == 'processing' ? 'selected' : ''}}>Processing</option>
                                                    <option value="succeeded" {{$order->paymentStatus == 'succeeded' ? 'selected' : ''}}>Succeeded</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PWN Health Requisition Order:</td>
                                        <td>
                                            @if(!empty($order->pwh_order_id))
                                                <form action="{{route('downloadRequisitionOrder',$order->pwh_order_id)}}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Download Requisition Order</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PWN Health Order Link:</td>
                                        <td style="word-break: break-all;"><a href="{{$order->pwh_order_link}}">{{$order->pwh_order_link}}</a></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <table class="table cart-item-table table-bordered table-topbot table-valign">
                                    <thead>
                                    <tr>
                                        <th class="col-sm-6 ">LAB TEST</th>
                                        <th class="col-sm-2 text-center">PRICES</th>
                                        <th class="col-sm-2 text-center">QUANTITY</th>
                                        <th class="col-sm-2 text-center">TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->details as $product)
                                        <tr>
                                            <td class="text-left">
                                                <a href="{{route('product_detail',['slug' => $product->product_id])}}"
                                                   class="view-cat-link">{{$product->product->name}}</a>
                                            </td>
                                            <td class="text-center">
                                                ${{$product->price}}
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group d-flex justify-content-center">
                                                    {{$product->quantity}}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                ${{$product->price * $product->quantity}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 col-lg-offset-6">
                                <table class="table table-bordered table-topbot">
                                    <thead>
                                    <tr>
                                        <th colspan="2">CART TOTALS</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td class="text-left" for="LAB TEST">Subtotal</td>
                                        <td for="PRICES">${{$order->totalAmount}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" for="LAB TEST">Total</td>
                                        <td for="PRICES">${{$order->totalAmount}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
<script>
    $('#orderStatus').on('change',function (){
        $('#formOrderStatus').submit();
    })
    $('#paymentStatus').on('change',function (){
        $('#formPaymentStatus').submit();
    })
    $('.submit_form').on('click',function(){
        $('#publicPwhResult').submit();
    })
</script>
@stop
