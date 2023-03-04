@extends('layouts.site')
@section('title'){{ $bundle->name }}@endsection
@section('description'){{ strip_tags($bundle->description) }}@endsection
@section('keywords'){{ $bundle->keywords }}@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url({{asset('/front/images/testmenu2.jpg')}});">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>{{ $bundle->name }}</h2>
                <h3 style="margin-top: 0">(Bundle Package)</h3>
            </div>
        </div>
    </section>
    <section class="description-area">
        <div class="container">
            <div class="description-box col-sm-6">
                <div class="description__inr">
                    <h3>List Tests In Bundle Package</h3>
                    <div>
                        <table class="table table-area0 table-striped table-bordered">
                            <tr>
                                <th>Tests Names</th>
                            </tr>
                            @foreach($bundle->productBundle as $productBundle)
                                @php
                                    $product = $productBundle->product;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-space-between align-item-center">
                                            <a href="{{route('product_detail',['slug' => $product->slug])}}" style="color: #333">{{ $product->name }}</a>
                                            <a class="btn btn-view" href="{{route('product_detail',['slug' => $product->slug])}}">View</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>


                <div class="description__inr">
                    <div class="description__cont">
                        <h3>Description</h3>
                        {!! $bundle->description !!}
                    </div>
                </div>
            </div>
            <div class="description-box col-sm-6">
                <div class="description__inr">

                    <div class="circle__cont text-center">
                        <div>
                            <h3>{{ $bundle->name }}</h3>
                            @if ($bundle->sale_price != null)
                                <h2><sup>{{setting('site.currency')}}</sup>{{ format_price($bundle->sale_price)}}</h2>
                                <strong>Average competitors price</strong>
                                <h4><sup>{{setting('site.currency')}}</sup>{{  format_price($bundle->price) }}</h4>
                            @else
                                <h2><sup>{{setting('site.currency')}}</sup>{{ format_price($bundle->price) }}</h2>
                                <strong>Average competitors price</strong><br>
                                <strong>Pricing based on average direct to consumer pricing.</strong>
                            @endif
                            <div class="checkout-area">
                                <form method="POST" action="{{route('cart.add')}}">
                                    @csrf
                                    <input type="hidden" value="1" name="quantity" id="quantity"/>
                                    <input type="hidden" name="price" id="price" value="{{$bundle->price}}"/>
                                    <input type="hidden" name="product_id" id="product_id" value="{{$bundle->id}}"/>
                                    <input type="hidden" name="name" id="name" value="{{$bundle->name}}"/>
                                    <input type="hidden" name="slug" id="slug" value="{{$bundle->slug}}"/>
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
        <div class="container pt50">
            <div class="fasting-cont fasting-list clrlist listview">
                {!! $bundle->requirement !!}
            </div>
        </div>
    </section>
@endsection
