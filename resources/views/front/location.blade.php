@extends('layouts.site')
@section('css')
    <style>
        .loc__contact-info li .title{
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .loc__contact-info li .operation_hours{
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
        }
        .font-bold {
            font-weight: bold !important;
        }

    </style>
@stop
@section('content')
    <section class="inr-bnr-blank">
        <div class="container">
            <div class="hed">
                <h2>{{$location['site_name'] . " " . $location['site_descriptor']}}</h2>
                <h4>{{$location['address_1']}} {{$location['city']}}, {{$location['state_abbreviation']}} {{$location['zipcode']}}</h4>
                <h5>{{$location['address_landmark']}}</h5>
            </div>
        </div>
    </section>

    <section class="location-area pt30 pb30">
        <div class="container">

            <div class="map-area col-sm-8">
                <div id="map" style="height: 450px;"></div>
            </div>
            <div class="lab-location-area col-sm-4">

                <div class="loc__contact-info list-icon clrlist listview">
                    <ul>
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <div><span class="title">Operation Hours</span></div>
                            @foreach($location['standardized_operation_hours'] as $dayOfWeek => $timeOpen)
                                <div class="operation_hours @if(date('D') == substr($dayOfWeek,0,3)) font-bold @endif">
                                    <span>{{$dayOfWeek}}</span>
                                    <span>{{$timeOpen == "X" ? "CLOSED" : $timeOpen}}</span>
                                </div>
                            @endforeach
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <div><span class="title">Phone</span></div>
                            <div><span>{{$location['phone']}}</span></div>
                        </li>
                        <li>
                            <i class="fa fa-fax"></i>
                            <div><span class="title">Fax</span></div>
                            <div><span>{{$location['fax']}}</span></div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
    <section class="box-area text-center pt20 pb50">
        <div class="container">

            <div class="box col-sm-4 anime-left ">
                <div class="box__img">
                    <img src="{{ asset('front/images/pic.jpg') }}" alt="" />
                </div>
                <div class="box__cont ">
                    <p>We make getting blood draws Easy and convenient for you</p>
                </div>
            </div>


            <div class="box col-sm-4 anime-in">
                <div class="box__img">
                    <img src="{{ asset('front/images/postBanner.png') }}" alt="" />
                </div>
                <div class="box__cont">
                    <p>No appointments needed Walk-ins are welcome You are in and out!</p>
                </div>
            </div>


            <div class="box col-sm-4 anime-right">
                <div class="box__img">
                    <img src="{{ asset('front/images/latestPost2.png') }}" alt="" />
                </div>
                <div class="box__cont">
                    <p>Access your results in 72 hour</p>
                </div>
            </div>


        </div>
    </section>
    <script>
        function initMap() {
            var uluru = {lat: {{ $location['latitude'] }}, lng: {{ $location['longitude'] }}};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
                title: '{{$location['site_name'] . " " . $location['site_descriptor']}}'
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap">
    </script>
@endsection
