@php
    use Jenssegers\Agent\Agent as Agent;
    $Agent = new Agent();
    $body = json_decode($page->body);
@endphp
@extends('layouts.site')
@section('title'){{ $page->meta_title }}@endsection
@section('description'){{ $page->meta_description }}@endsection
@section('keywords'){{ $page->meta_keywords }}@endsection
@section('content')
    <section class="slider-area no-ctrl fadeft">
        <div class="carousel slide" data-interval="false" data-ride="carousel" id="carousel-example-generic">
            <ol class="carousel-indicators hidden">
                <li class="active" data-slide-to="0" data-target="#carousel-example-generic">&nbsp;</li>
                <li data-slide-to="1" data-target="#carousel-example-generic">&nbsp;</li>
                <li data-slide-to="2" data-target="#carousel-example-generic">&nbsp;</li>
            </ol>
            <!-- Wrapper for slides -->

            <div class="carousel-inner">
                <div class="item active">
                    <img alt="..." src="{{image($body->banner)}}"/>
                    <div class="container posrel">
                        <div class="caro-caps anime-flipInX">
                            <h1>{!! $body->title_banner ?? null !!}</h1>

                            <p>{!! $body->desc_banner ?? null !!}</p>
                            @if(!is_customer())
                                <div class="lnk-btn inline-block more-btn"><a href="{{route('register')}}">Sign Up With Us</a></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="box-area text-center" style="margin-top: 5rem;">
        <div class="container">
            <div class="counter blue">
                <div class="counter-icon">
                    <img src="{{asset('front/images/labs-icon.png')}}">
                </div>
                <h3>Monthly Labs</h3>
                <span class="counter-value">{{$body->counter_number ?? 4000}}</span>
            </div>
        </div>
    </section>

    <section class="box-area text-center pt20 pb50">
        <div class="hed">
            <h2>{!! $body->title_section1 ?? null !!}</h2>

            <p>{!! $body->desc_section1 ?? null !!}</p>
        </div>
    </section>
    <section class="slider-area no-ctrl fadeft  pb50">
        <div class="box-area text-center col-md-4">
            <div class="box col-sm-12 anime-left ">
                <a href="javascript:void(0)" style="color: #333">

                    <div class="box__img"><img alt="" src="{{image($body->img_icon_1_section1 ?? null)}}"/></div>

                    <div class="box__cont ">
                        <h4>{!! $body->title_icon_1_section1 ?? null !!}</h4>

                        <p>{!! $body->desc_icon_1_section1 ?? null !!}</p>

                        <div class="lnk-btn more-btn"><a href="#">LEARN MORE</a></div>
                    </div>
                </a>
            </div>

            <div class="box col-sm-12 anime-in">
                <a href="javascript:void(0)" style="color: #333">

                    <div class="box__img"><img alt="" src="{{image($body->img_icon_2_section1 ?? null)}}"/></div>

                    <div class="box__cont">
                        <h4>{!! $body->title_icon_2_section1 ?? null !!}</h4>

                        <p>{!! $body->title_icon_2_section1 ?? null !!}</p>

                        <div class="lnk-btn more-btn"><a href="#">LEARN MORE</a></div>
                    </div>
                </a>
            </div>

            <div class="box col-sm-12 anime-right">
                <a href="{{route('locations')}}" style="color: #333">
                    <div class="box__img"><img alt="" src="{{image($body->img_icon_3_section1 ?? null)}}"/></div>

                    <div class="box__cont">
                        <h4>{!! $body->title_icon_3_section1 ?? null !!}</h4>

                        <p>{!! $body->title_icon_3_section1 ?? null !!}</p>

                        <div class="lnk-btn more-btn"><a href="#">LEARN MORE</a></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-sm-12">
                @php
                    $url = $body->link_video_section1 ?? null;
                    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                @endphp
                <iframe width="100%"
                        {{$Agent->isMobile() ? '' :'height=550' }}  src="https://www.youtube.com/embed/{{ $my_array_of_vars['v'] ?? null}}?rel=0"
                        frameborder="0"
                        allow=" autoplay; clipboard-write; encrypted-media; gyroscope"
                        allowfullscreen></iframe>
            </div>
        </div>

    </section>
    @php $bodyAboutUs = json_decode($about->body) @endphp
    <section class="testlab-area text-center bg-full white p100 mt50 valigner"
             style="background-image:url('{{image($bodyAboutUs->image_section2 ?? null)}}');">
        <div class="container">
            <div class="valign ">
                <h4>{!! $bodyAboutUs->desc_section2 ?? null !!}</h4>

                <div class="inline-btns mt40">
                    <div class="lnk-btn inline-block def-btn hover"><a href="{{ $bodyAboutUs->link_section2 ?? null}}">View Tests</a></div>
                </div>
            </div>
        </div>
    </section>

    <section class="most-area text-center bg-full pt50 pb50">
        <div class="container">
            <div class="most__cont col-sm-7 valigner anime-left">
                <div class="valign">
                    <h3>{!! $body->title_section2 ?? null !!}</h3>

                    <p>{!! $body->desc_section2 ?? null !!}</p>

                    <div class="lnk-btn browse-btn"><a href="{{route('shop')}}">View all Test &gt;&gt;</a></div>
                </div>
            </div>

            <div class="most__img col-sm-5">
                <div class="most__inr box">
                    <div class="most__inr__img hidden"><img alt="" src="/front/images/box1.jpg"/>
                    </div>

                    <div class="most__inr__cont text-center ">
                        <h3>CMP</h3>

                        <p>(Complete Metabolic Panel)</p>
                        @if ($body->sale_price_section2 != null)
                            <h2><sup>{{setting('site.currency')}}</sup>{{ $body->sale_price_section2}}</h2>
                            <strong>Average competitors price</strong>
                            <h4><sup>{{setting('site.currency')}}</sup>{{$body->price_section2 ?? null}}</h4>
                        @else
                            <h2><sup>{{setting('site.currency')}}</sup>{{ $body->price_section2 ?? null }}</h2>
                            <strong>Average competitors price</strong>
                        @endif
                        <strong>Pricing based on average direct to consumer pricing.</strong></div>
                </div>
            </div>
        </div>
    </section>

    <section class="most-area text-center pt50 pb50">
        <div class="container">
            <div class="most__cont col-sm-7 valigner anime-right pul-rgt">
                <div class="valign">
                    <h3>{!! $body->title_section3 ?? null !!}</h3>

                    <p>{!! $body->desc_section3 ?? null !!}</p>

                    <div class="lnk-btn browse-btn"><a href="{{route('how-to-order')}}">Let&rsquo;s Get Proactive &gt;&gt;</a>
                    </div>
                </div>
            </div>

            <div class="most__img col-sm-5 pul-lft ">
                <div class="most__inr box">
                    <div class="most__inr__img"><img alt="" src="{{ image($body->image_section3 ?? null ) }}"/></div>
                </div>
            </div>
        </div>
    </section>


    <section class="box-area text-center pt20 pb50 anime-in">
        <div class="container">
            <div class="hed">
                <h2>{{$body->title_section5 ?? null}}</h2>
            </div>
            @for($i = 1; $i <= 8; $i++)
                @if ($i == 1 || $i == 5)
                    <div class="our-services {{$i == 1 ? 'fadeInLeft' : 'fadeInRight'}}" style="margin-top: 2rem">
                @endif
                @php $imageName = "image_{$i}_section5" @endphp
                    <div><img src="{{ isset($body->$imageName) ? image($body->$imageName) : "https://via.placeholder.com/200" }}" alt=""></div>
                @if ($i == 4 || $i == 8)
                    </div>
                @endif
            @endfor
        </div>
    </section>


    <section class="testlab-area text-center bg-full white p100 valigner mt40 rotate-img--hover"
             style="background-image: url('{{ image($body->image_section4 ?? null ) }}')">
        <div class="container">
            <div class="valign">
                <h4><i class="fa fa-quote-left" ></i>{!! $body->title_section4 ?? null !!}<i class="fa fa-quote-right" ></i>
                </h4>
            </div>
        </div>
    </section>
    @php
        $faqBody = json_decode($faq->body);
    @endphp
    <section class="faq-area pb50">
        <div class="container">
            <div class="hed text-center">
                <h2>FAQ</h2>
            </div>
            <div class="cont">
                {!! $faqBody->content_page !!}
                <div class="panel-group accordion-arr" id="accordion">
                    <div class="col-sm-6 p0">
                        @if(!empty($faqBody->detail))
                            @php $i = 0; @endphp
                            @foreach($faqBody->detail as $detail_left)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse"
                                                                   href="#collapse{{$i}}">{!! $detail_left->left_title !!}</a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse " id="collapse{{$i}}">
                                        <div class="panel-body">{!! $detail_left->left_content !!}
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @endif
                    </div>
                    <div class="col-sm-6 p0">
                        @if(!empty($faqBody->detail))
                            @php $i = 100; @endphp
                            @foreach($faqBody->detail as $detail_right)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse"
                                                                   href="#collapse{{$i}}">{!! $detail_right->right_title !!}</a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse " id="collapse{{$i}}">
                                        <div class="panel-body">{!! $detail_right->right_content !!}
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.counter-value').each(function(){
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                },{
                    duration: 3500,
                    easing: 'swing',
                    step: function (now){
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });
    </script>
@stop
