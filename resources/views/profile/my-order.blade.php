@php
    use Carbon\Carbon as Carbon;
@endphp
@extends('layouts.site')
@section('title')
    My Orders
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
                <h2>My Orders</h2>
                <h4></h4>
            </div>
        </div>
    </section>

    <section class="billing-area ">
        <div class="container">
            <div class="page-content container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                @if(user()->role_id == 1)
                                    <form action="" method="GET">
                                        <div class="row col-md-12">
                                            <div class="col-md-3 col-sm-12">
                                                <label for="">Order ID</label>
                                                <input type="text" class="form-control" name="order_id" value="{{request()->get('order_id')}}">
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <label for="">Last Name Or First Name</label>
                                                <input type="text" class="form-control" name="name" value="{{request()->get('name')}}">
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <label for="">Nick Name</label>
                                                <input type="text" class="form-control" name="nick_name" value="{{request()->get('nick_name')}}">
                                            </div>
                                            <div class="col-md-2 col-sm-12" style="margin-top: 30px;display: flex">
                                                <button type="submit" class="btn btn-success"> Search </button>
                                                <a class="btn btn-default" style="margin-left: 10px" onclick="location.href = '{{route('myOrder')}}'"> Cancel </a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-12 col-sm-12 pb50 pt50">
                                        @if(count($orders) > 0)
                                        <div class="panel-group" id="accordion">
                                            @foreach($orders as $order)
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title" style="line-height: 30px">
                                                            <a data-toggle="collapse" data-parent="#accordion"
                                                               href="#collapse{{$order->id}}">
                                                                {{$order->nick_name .' #'.$order->id}} {{$order->lastName .', '.$order->firstName}} - {{\Carbon\Carbon::createFromFormat('Y-m-d',$order->dob)->format('M. jS, Y')}}</a>
                                                        </h3>
                                                    </div>
                                                    <div id="collapse{{$order->id}}" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <div class="row">
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
                                                                                <div style="text-transform: capitalize">
                                                                                    {{$order->orderStatus}}</div>
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
                                                                                    <div>PWH Order Result</div>
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
                                                                                            <a href="{{route('product_detail',['slug' => $product->product_id])}}"
                                                                                               class="view-cat-link">{{$product->product->name}}</a>
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
                                                </div>
                                        @endforeach
                                        @else
                                            <div style="text-align: center " class="alert alert-danger">There is no result</div>
                                        @endif
                                    </div>
                            </div>
                            @else
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Create At</th>
                                        <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->firstName.' '.$order->lastName}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{setting('site.currency')}}{{format_price($order->totalAmount)}}</td>
                                            <td>{{$order->paymentStatus}}</td>
                                            <td>{{$order->orderStatus}}</td>
                                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->created_at)->format('M. jS, Y')}}</td>
                                            <td class="no-sort no-click bread-actions">
                                                <a href="{{route('orderDetail', ['id' => $order->id])}}" title="Edit"
                                                   class="btn btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Detail</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                'voyager::generic.showing_entries', $orders->total(), [
                                    'from' => $orders->firstItem(),
                                    'to' => $orders->lastItem(),
                                    'all' => $orders->total()
                                ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $orders->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        function getParameter(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                    tmp = item.split("=");
                    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        }

        $(document).ready(function () {
            var orderId = getParameter('order_id');
            if(orderId) {
                $('a[href="#collapse56"]').trigger('click');
            }
        })
    </script>
@endsection
