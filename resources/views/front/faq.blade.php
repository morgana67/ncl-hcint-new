@extends('layouts.site')
@section('title'){{ $faq->meta_title }}@endsection
@section('description'){{ $faq->meta_description }}@endsection
@section('keywords'){{ $faq->meta_keywords }}@endsection
@section('content')
    @php
        $faqBody = json_decode($faq->body);
    @endphp
    <section class="inr-intro-area pt100 pb40">
        <div class="container">
            <div class="hed text-center">
                <h2>{{ strtoupper($faq->title)}}</h2>
            </div>

            <div calss="cont">
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
