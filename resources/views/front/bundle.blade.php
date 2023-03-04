@php
    use Jenssegers\Agent\Agent as Agent;
    $Agent = new Agent();
@endphp
@extends('layouts.site')
@section('title'){{ 'Bundle' }}@endsection
@section('description'){{'Bundle'}}@endsection
@section('keywords'){{'Bundle'}}@endsection
@section('css')
   <style>
       #example tr th{
           text-align: left;
       }
       #example tr td .btn-view {
           font-size: 12px;
           border: 1px solid #39c;
           color: #000;
           padding: 2px 5px;
           background: #fff;
       }

       .lnk-btn .view-bundle {
           color: #333 !important;
           background-color: #fff !important;
           border-color: #ccc !important;
           font-size: 14px;
           height: 34px;
       }
       .pack-box:hover .view-bundle {
           color: #333 !important;
           background-color: #fff !important;
           border-color: #ccc !important;
       }
       .pack-box:hover .view-bundle:hover {
           color: #333 !important;
           background-color: #e6e6e6 !important;
           border-color: #adadad !important;
       }
   </style>
@endsection
@section('content')
    <section class="inr-intro-area pt100 pb40">
        <div class="container">
            <div class="page__title text-center mb30">
                <h2>BUNDLE PACKAGE TEST</h2>
                <span></span>
            </div>

            <p>We want you to get the most information about your body when information about “you” matter most. From
                wellness starters to proactive warrior&reg; tests holding over 100 bio markers, you get actionable
                information at your fingertips. You can order bundle tests and add individual tests from our test
                menu</p>
        </div>
    </section>
    @if(count($bundlesFeatured) > 0)
    <section class="packages-area bg-snow p30 mb30 box-scale--hover">
        <div class="container">
            <h3 class="text-center">FEATURED BUNDLE PACKAGE</h3>
           @foreach ($bundlesFeatured as $bundle)
            <div class="pack-box col-sm-3 ">
                <div clsas="pack__hed">
                    <h4>{{$bundle->name}}</h4>
                    <h2>
                        @if($bundle->sale_price !=  null)
                            <span id="old_price" style="text-decoration: line-through;">${{ format_price($bundle->price) }}</span>
                            <span id="price">{{setting('site.currency')}}{{ format_price($bundle->sale_price) }}</span>
                        @else
                            <span id="price">{{setting('site.currency')}}{{ format_price($bundle->price) }}</span>
                        @endif
                    </h2>
                    <div class="rating-area clrlist">
                        <ul>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="cont">
                    <p>{!! $bundle->description  !!} </p>
                    <div class="lnk-btn inline-btns">
                        <form method="POST" action="{{route('cart.add')}}">
                            @csrf
                            <input type="hidden" value="1" name="quantity" id="quantity"/>
                            <input type="hidden" name="price" id="price" value="{{$bundle->price}}"/>
                            <input type="hidden" name="product_id" id="product_id" value="{{$bundle->id}}"/>
                            <input type="hidden" name="name" id="name" value="{{$bundle->name}}"/>
                            <input type="hidden" name="slug" id="slug" value="{{$bundle->slug}}"/>
                            <a href="{{route('bundle.show',['slug' => $bundle->slug])}}" class="out-btn btn btn-default view-bundle">VIEW</a>
                            <button id="btn_add_to_cart" class="out-btn btn btn-default">CHECKOUT</button>
                        </form>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </section>
    @endif
    <section class="test-bd-area pt50 pb50">
        <div class="container">
            <h3 class="text-center">LIST BUNDLE PACKAGE</h3>
            <div class="test-menu-area">
                <table id="example" class="table table-area0 table-striped table-bordered" cellspacing="0" width="100%" style="margin-top: 30px">
                    <thead>
                    <tr>
                        <th>Bundle Package Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bundles as $bundle)
                        <tr>
                            <td class="d-flex justify-content-space-between">
                                <a href="{{route('bundle.show',['slug' => $bundle->slug])}}">{{ $bundle->name }}</a>
                                <div class="actions">
                                    <a class="btn btn-view" href="{{route('bundle.show',['slug' => $bundle->slug])}}">View</a>
                                    <form method="POST" action="{{route('cart.add')}}" class="inline-block">
                                        @csrf
                                        <input type="hidden" value="1" name="quantity" id="quantity"/>
                                        <input type="hidden" name="price" id="price" value="{{$bundle->price}}"/>
                                        <input type="hidden" name="product_id" id="product_id" value="{{$bundle->id}}"/>
                                        <input type="hidden" name="name" id="name" value="{{$bundle->name}}"/>
                                        <input type="hidden" name="slug" id="slug" value="{{$bundle->slug}}"/>
                                        <button id="btn_add_to_cart" class="btn btn-view">CHECKOUT</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
