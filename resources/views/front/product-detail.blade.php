@extends('layouts.site')
@section('title'){{ $product->name }}@endsection
@section('description'){{ strip_tags($product->short_description) !== '' ? strip_tags($product->short_description) : config('front.meta_description') }}@endsection
@section('keywords'){{ $product->keywords }}@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url({{asset('/front/images/testmenu2.jpg')}});">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2></h2>
                <h3>{{ $product->name }}</h3>
            </div>
        </div>
    </section>
    <section class="description-area">
        <div class="container">
            <div class="description-box col-sm-6">
                <div class="description__inr">
                    <div class="description__cont">
                        <h3>Description</h3>
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
            <div class="description-box col-sm-6">
                <div class="description__inr">

                    <div class="circle__cont text-center">
                        <div>
                            <h3>{{ $product->name }}</h3>
                            @php
                              if($product->sale_price != null){
                                    $price = $product->sale_price;
                                }else{
                                    $price = $product->price;
                                }
                            @endphp
                            @if($price_for_doctor['is_doctor'])
                                @if($price_for_doctor['price'] > 0)
                                @php $price = $price_for_doctor['price']; @endphp
                                <h2><sup>{{setting('site.currency')}}</sup>{{ format_price($price_for_doctor['price']) }}</h2>
                                <strong>Average competitors price</strong>
                                <h4><sup>{{setting('site.currency')}}</sup>{{  format_price($product->price) }}</h4>
                                @else
                                <h2><sup>{{setting('site.currency')}}</sup>{{ format_price($price) }}</h2>
                                <strong>Average competitors price</strong>
                                <h4><sup>{{setting('site.currency')}}</sup>{{  format_price($product->price) }}</h4>
                                @endif
                            @else
                                @if ($product->sale_price != null)
                                    <h2><sup>{{setting('site.currency')}}</sup>{{ format_price($price)}}</h2>
                                    <strong>Average competitors price</strong>
                                    <h4><sup>{{setting('site.currency')}}</sup>{{  format_price($product->price) }}</h4>
                                @else
                                    <h2><sup>{{setting('site.currency')}}</sup>{{ $price }}</h2>
                                    @endif
                                    <strong>Pricing based on average direct to consumer pricing.</strong><br>
                            @endif
                            <strong>{{$product->price_text ?? ""}}</strong>
                            <div class="checkout-area">
                                <form method="POST" action="{{route('cart.add')}}">
                                    @csrf
                                    <input type="hidden" value="1" name="quantity" id="quantity"/>
                                    <input type="hidden" name="price" id="price" value="{{$price}}"/>
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}"/>
                                    <input type="hidden" name="name" id="name" value="{{$product->name}}"/>
                                    <input type="hidden" name="slug" id="slug" value="{{$product->slug}}"/>
                                    <button id="btn_add_to_cart" class="out-btn btn btn-default">CHECKOUT</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fasting-area">
        <div class="container">
            <div class="fasting-cont fasting-list clrlist listview">
                {!! $product->requirement !!}
            </div>
        </div>
    </section>
@endsection
