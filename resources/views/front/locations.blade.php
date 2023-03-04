@extends('layouts.site')
@section('title')
    Locations
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('front/plugin/select2/css/select2.min.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            border-radius: 0 !important;
            border: 1px solid #ccc;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        span {
            outline: none !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
        }
    </style>
@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('/front/images/map-bnr.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>LOCATIONS</h2>
                <h4></h4>
            </div>
        </div>
    </section>


    <section class="inr-intro-area">

        <section class="location-area pt30 pb30">
            <div class="container">
                <div class="map-area loc__fom row p0">
                    <form method="get" class="search-fom rds mb30" action="{{route('locations')}}">
                        <input type="hidden" id="lat" name="lat" value="{{request()->get('lat')}}"/>
                        <input type="hidden" id="lng" name="lng" value="{{request()->get('lng')}}"/>
                        <div class="form-group col-sm-5">
                            <label for="search">Address</label>
                            <input type="text" placeholder="Enter a location" class="form-control" name="address" id="address" required
                                   autocomplete="off" value="{{request()->get('address')}}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="search">What testing do you need?</label>
                            <select id="activity" class="form-control" name="activity" required>
                                <option value="" >Select an Option</option>
                                @foreach(pscActivities() as $pscActivity)
                                    <option {{request()->get('activity') == $pscActivity['value'] ? 'selected' : ''}} value="{{$pscActivity['value']}}">{{$pscActivity['display']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group  col-sm-3">
                            <input type="hidden" name="search" id="search" value="1">
                            <button class="btn " type="submit"><span>Search</span> <i class="fa fa-search fa-2x"></i>
                            </button>
                        </div>
                    </form>
                    <div id="suggested_locations" style="display:none;" class="form-group has-feedback"></div>
                </div>
                <div class="map-area loc__list col-sm-12 p0">
                    @if($errors->count() > 0 )
                        <div class="alert alert-danger">There are no laboratories within 25 miles of the location you entered.</div>
                    @endif
                    @if(count($locations) > 0)
                        <table id="example" class="table table-area0 table-striped table-bordered" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th class="clrhm p20"><h3>Locations</h3></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td>
                                        <div id="{{$location['site_code']}}" class="clrhm">
                                            <a tabindex="1" href="{{url('location')}}/{{$location['site_code']}}">
                                                <i class="fa fa-map-marker fa-2x"></i>
                                                <span style="color: gray">{{$location['distance']}} miles</span>
                                                <h3> {{$location['site_name']}} </h3>
                                                <span> {{$location['address_1']}} {{$location['city']}}, {{$location['state_abbreviation']}} {{$location['zipcode']}} </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tbody>
                        </table>
                    @endif
                </div>
            </div>
        </section>


    </section>
    <section class="box-area text-center pt20 pb50">
        <div class="container">

            <div class="box col-sm-4 anime-left ">
                <div class="box__img">
                    <img src="front/images/pic.jpg" alt=""/>
                </div>
                <div class="box__cont ">
                    <p>We make getting blood draws Easy and convenient for you</p>
                </div>
            </div>


            <div class="box col-sm-4 anime-in">
                <div class="box__img">
                    <img src="front/images/postBanner.png" alt=""/>
                </div>
                <div class="box__cont">
                    <p>No appointments needed Walk-ins are welcome You are in and out!</p>
                </div>
            </div>


            <div class="box col-sm-4 anime-right">
                <div class="box__img">
                    <img src="front/images/latestPost2.png" alt=""/>
                </div>
                <div class="box__cont">
                    <p>Access your results in 72 hours</p>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initialize"></script>
    <script>
        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                debugger;
                var place = autocomplete.getPlace();
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
            });
        }
    </script>
@stop
