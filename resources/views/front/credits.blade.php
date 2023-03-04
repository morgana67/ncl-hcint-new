@extends('layouts.site')
@section('title'){{ $page->title }}@endsection
@section('description'){{ $page->meta_description }}@endsection
@section('keywords'){{ $page->meta_keywords }}@endsection
@section('content')
    <section class="inr-intro-area pt100 ">
        <div class="container">
            <div class="page__title text-center mb30">
                <h2>{{ strtoupper($page->title) }}</h2>
            </div>
        </div>
    </section>

    <section class="cont-area  pt30 pb30 big ">
        <div class="container">
            {!! $page->body !!}
        </div>
    </section>
@endsection
