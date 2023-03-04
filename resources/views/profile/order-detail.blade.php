@php
    use Carbon\Carbon as Carbon
@endphp
@extends('layouts.site')
@section('title')
    Order Detail
@endsection
@section('css')
    <style type="text/css">
        .order-info-item {
            display: grid;
            grid-template-columns: 150px auto;
            grid-row-gap: 15px;
            padding: 10px 0;
            font-size: 14px;
            border-bottom: 1px solid #ccc;
        }
        .order-info-item:last-child {
            border-bottom: unset;
        }
        .order-info-item div:first-child {
            font-weight: bold;
        }
        .panel-heading {
            font-weight: bold;
        }
        .panel-custom {
            border-color: #39c;
            box-shadow: 0 0 0 5px #eee;
        }
        .panel-custom>.panel-heading {
            color: #fff;
            background-color: #39c;
            border-color: #39c;
        }
    </style>
@stop
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('/front/images/bnr-signup.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Order Details</h2>
                <h4></h4>
            </div>
        </div>
    </section>
    <section class="billing-area ">
        <div class="container">
            <div class="page-content read container-fluid">
                <div class="row" style="padding: 50px 0">
                    <div class="col-md-6" style="margin-bottom: 25px">
                        <div class="panel panel-custom">
                            <div class="panel-heading">Order Information</div>
                            <div class="panel-body" >
                                <div class="order-info-item">
                                    <div>Order ID</div>
                                    <div>#{{$order->id}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Email</div>
                                    <div>{{$order->email}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Payment Status</div>
                                    <div style="text-transform: capitalize">
                                        {{$order->paymentStatus}}
                                    </div>
                                </div>
                                <div class="order-info-item">
                                    <div>Order Status</div>
                                    <div style="text-transform: capitalize">{{$order->orderStatus}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>PWN Requisition Order</div>
                                    <div>
                                        @if(!empty($order->pwh_order_id))
                                            <form action="{{route('downloadRequisitionOrder',$order->pwh_order_id)}}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Download Requisition Order</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="order-info-item">
                                    <div>PWN Order Link</div>
                                    <div style="word-break: break-all;"><a href="{{$order->pwh_order_link}}" class="btn btn-primary">Order Link</a></div>
                                </div>
                                <div class="order-info-item">
                                    <div>PWN Status</div>
                                    <div><p>{{$order->pwh_status}}</p></div>
                                </div>
                                @if(strpos($order->pwh_status, 'Result') !== false)
                                    <div class="order-info-item">
                                        <div>PWN Order Result</div>
                                        <div>
                                            @if(!empty($order->pwh_order_id))
                                                <form action="{{route('downloadResultTest',$order->pwh_order_id)}}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Download Order Result</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="order-info-item">
                                    <div>Additional Message</div>
                                    <div style="width: 100%; word-wrap: break-word">{{$order->message}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-bottom: 25px">
                        <div class="panel panel-custom">
                            <div class="panel-heading">Patient Information</div>
                            <div class="panel-body" >
                                <div class="order-info-item">
                                    <div>Name</div>
                                    <div>{{$order->firstName.' '.$order->lastName}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Date of Birth</div>
                                    <div>{{$order->dob ? \Carbon\Carbon::createFromFormat('Y-m-d',$order->dob)->format('M. jS, Y') : ""}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Gender</div>
                                    <div>{{$order->gender == "m" ? "Male" : "Female"}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Phone</div>
                                    <div>{{$order->phone}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Address</div>
                                    <div>{{$order->address}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Address2</div>
                                    <div>{{$order->address2}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>County</div>
                                    <div>{{$order->country->name}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>State</div>
                                    <div>{{$order->state}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>City</div>
                                    <div>{{$order->city}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>Zip</div>
                                    <div>{{$order->zip}}</div>
                                </div>
                                <div class="order-info-item">
                                    <div>City</div>
                                    <div>{{$order->city}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 25px">
                        <div class="panel panel-custom">
                            <div class="panel-heading">Test Summary</div>
                            <div class="panel-body" >
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
                                                @if($product->product->type == 'bundle')
                                                    <a href="{{route('bundle.show',['slug' => $product->product->slug])}}"
                                                       class="view-cat-link">{{$product->product->name}} (Bundle Package)</a>
                                                @else
                                                    <a href="{{route('product_detail',['slug' => $product->product_id])}}"
                                                       class="view-cat-link">{{$product->product->name}}</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{setting('site.currency')}}{{format_price($product->price)}}
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group d-flex justify-content-center">
                                                    {{$product->quantity}}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{setting('site.currency')}}{{format_price($product->price * $product->quantity)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-center">Sub Total</td>
                                        <td class="text-center">{{setting('site.currency')}} {{format_price($order->totalAmount)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td class="text-center">Total</td>
                                        <td class="text-center">{{setting('site.currency')}} {{format_price($order->totalAmount)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
