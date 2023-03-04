@extends('layouts.site')
@section('title'){{ $page->meta_title }}@endsection
@section('description'){{ $page->meta_description }}@endsection
@section('keywords'){{ $page->meta_keywords }}@endsection
@php
    $body = json_decode($page->body);
@endphp
@section('content')
    <section class="page-bnr-area bg-full bg-cntr valigner" style="background-image:url('{{image($body->banner ?? null)}}');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>{{ strtoupper($page->title) }}</h2>

                <h3>{!! $body->desc_banner ?? null !!}</h3>
            </div>
        </div>
    </section>

    <section class="about-area pt50 pb50">
        <div class="container">
            <div class="cont">
               {!! $body->desc_section1 ?? null !!}
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="about-box col-sm-4 anime-left">
                <div class="about__icon"><img alt="" src="{{image($body->img_icon_1_section1 ?? null)}}"/></div>

                <div class="about__cont">
                    <h3>{!! $body->title_icon_1_section1 ?? null !!}</h3>

                    <p>{!! $body->desc_icon_1_section1 ?? null !!}</p>
                </div>
            </div>

            <div class="about-box col-sm-4 anime-in">
                <div class="about__icon"><img alt="" src="{{image($body->img_icon_2_section1 ?? null)}}"/></div>

                <div class="about__cont">
                    <h3>{!! $body->title_icon_2_section1 ?? null !!}</h3>

                    <p>{!! $body->desc_icon_2_section1 ?? null !!}</p>
                </div>
            </div>

            <div class="about-box col-sm-4 anime-right">
                <div class="about__icon"><img alt="" src="{{image($body->img_icon_3_section1 ?? null)}}"/></div>

                <div class="about__cont">
                    <h3>{!! $body->title_icon_3_section1 ?? null !!}</h3>

                    <p>{!! $body->desc_icon_3_section1 ?? null !!}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testlab-area text-center bg-full white p100 valigner"
             style="background-image:url('{{image($body->image_section2 ?? null)}}');">
        <div class="container">
            <div class="valign ">
                <h4>{!! $body->desc_section2 ?? null !!}</h4>

                <div class="inline-btns mt40">
                    <div class="lnk-btn inline-block def-btn hover"><a href="{{ $body->link_section2 ?? null}}">View Tests</a></div>
                </div>
            </div>
        </div>
    </section>
@endsection
