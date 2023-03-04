@extends('layouts.site')
@section('title'){{!empty($post->seo_title) ? $post->seo_title : $post->title}}@endsection
@section('description'){{$post->meta_description}}@endsection
@section('keywords'){{$post->meta_keywords}}@endsection
@section('css')
    <style>
        .bnr__cont h2 {
            padding: 0 10%;
        }
        @media only screen and (max-width : 480px) {
            .bnr__cont h2 {
                padding: 0;
            }
            .similar-post:first-child {
                margin-top: 0;
            }
            .similar-post {
                margin-top: 50px;
            }
        }
    </style>
@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{str_replace('\\', '/', image($post->image))}}'); background-position: 0 30%; background-repeat: no-repeat;background-size: cover;">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>{{$post->title}}</h2>
                <div class="dtl__postDay">
                    <ul>
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date("g:i a", strtotime($post->created_at)) }} </li>
                        <li><i class="fa fa-calendar" aria-hidden="true"></i> {{ date("F jS, Y", strtotime($post->created_at)) }} </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-dtl-area">
        <div class="container">
            <div class="dtl__postDay" style="height: 70px">
                <ul class="pull-right">
                    <li style="font-size: 14px"><i>Categorized in</i> <b><a href="{{route('blog', $post->category->slug)}}">{{$post->category->name}}</a></b></li>
                </ul>
            </div>
            <div class="dtl__main col-sm-12">
                <div class="dtl__content">
                    <object class="dtl__content">
                        {!! $post->body !!}
                    </object>
                </div>
                <div class="text-center" style="background-color: #f7f7f7; padding: 18px">
                    <h3 style="font-weight: bold">Talk to Our Medical Doctors for just $26.00<br>Order your Blood Tests from New Century Labs&nbsp;</h3>
                    <p style="font-size: 14px; font-weight: 500">Don't Just Think You're Healthy, Know You're Healthy.<br>Information about "YOU" on Demand</p>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-posted-area pb50 container">
        <hr style="margin: 20px 0">
        <div class="row">
                @foreach ($similarPosts as $similarPost)
                <div class="posted-box col-sm-4 similar-post">
                    <div class="posted__img">
                        <img src="{{ image($similarPost->image,'-medium') }}" alt="{{$similarPost->title}}" />
                        <div class="posted__hover">
                            <a href="{{route('post_detail',['slug' => $similarPost->slug])}}"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="posted__cont">
                        <div class="dtl__postDay">
                            <h3><a href="{{route('post_detail',['slug' => $similarPost->slug])}}">{{$similarPost->title}}</a></h3>
                            <ul style="padding: 0; display: flex;justify-content: space-between;align-content: center;">
                                <li><i class="fa fa-calendar" aria-hidden="true"></i>{{ date("F jS, Y", strtotime($similarPost->created_at)) }} </li>
                                <li class="text-right" style="padding: 0"><i class="fa fa-th-list"></i><a href="{{route('blog', $post->category->slug)}}">{{$post->category->name}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    </section>
@endsection
