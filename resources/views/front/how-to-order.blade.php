@extends('layouts.site')
@section('title'){{ $page->meta_title }}@endsection
@section('description'){{ $page->meta_description }}@endsection
@section('keywords'){{ $page->meta_keywords }}@endsection
@php
    $body = json_decode($page->body);
@endphp
@section('content')
    <section class="page-bnr-area bg-full valigner" style="background-image:url('{{image($body->banner ?? null)}}');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 anime-flipInX">
                <h2>{!! $body->title_banner ?? null !!}</h2>

                <p>{!! $body->desc_banner  ?? null !!}</p>
            </div>
        </div>
    </section>

    <section class="how-step-area pt50 pb50">
        <div class="container">
            @if(!empty($body->detail))
                @php $i = 1; @endphp
                @foreach($body->detail as $detail)
                    @if($i % 2 != 0)
                        <div class="step__cont col-sm-5">
                            <div class="step__img"><img alt="" src="{{ image($detail->image_step ?? null) }}"/></div>
                        </div>

                        <div class="step__cont col-sm-7 valigner anime-left">
                            <div class="step_list clrlist listview valign">
                                <h3>{!! $detail->title_step ?? null !!}</h3>
                                <ul>
                                    <li> {!! $detail->content_step ?? null !!}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                    @else
                        <div class="step__cont col-sm-7 valigner anime-left">
                            <div class="step_list clrlist listview valign">
                                <h3>{!! $detail->title_step ?? null !!}</h3>
                                <ul>
                                    <li> {!! $detail->content_step ?? null !!}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="step__cont col-sm-5">
                            <div class="step__img"><img alt="" src="{{ image($detail->image_step ?? null) }}"/></div>
                        </div>

                        <div class="clearfix">&nbsp;</div>
                    @endif
                    @php $i++ @endphp
                @endforeach
            @endif
        </div>
    </section>
@endsection
