@extends('layouts.site')
@section('css')
    <style>
        .require::after {
            content: '*';
            font-size: 36px;
            position: absolute;
            top: -5px;
            right: 20px;
            color: red;
        }
        .require-label {
            font-size: 32px;
            position: relative;
            top: 10px;
            color: red;
        }
    </style>
    <link rel="stylesheet" href="{{asset('front/css/jquery.passwordRequirements.css')}}">
@stop
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('front/images/bnr-signup.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                @if(isset($is_doctor_register))
                    <h2>Doctor Registration</h2>
                @else
                    <h2>SIGN UP</h2>
                @endif
            </div>
        </div>
    </section>

    <form method="POST" action="{{route('postRegister')}}" class="form" name="register">

        @csrf
        @if(isset($is_doctor_register))
            <input type="hidden" name="is_doctor_register" value="1">
        @endif
        <section class="billing-area ">
            @if(isset($is_doctor_register))
            <div class="container">
                <div class="alert alert-info pul-cntr col-sm-9 text-center" style="margin-top: 15px; margin-bottom: 0; font-size: 24px; color: #fff; background-color: #3399cc">
                    New Century Labs serves <strong class="count-doctors">1500</strong> doctors nation wide.
                </div>
            </div>
            @endif
            <div class="container mb50">
                <div class="fom fom-shad mt20 col-sm-9 p0 pul-cntr">
                    <div class="col-md-12">
                        @include('layouts.alert')
                        <h4 class="mt20 mb20">User Information</h4>
                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="First Name *" class="form-control" required="required" name="firstName"
                               type="text" value="{{old('firstName')}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="Last Name *" class="form-control" required="required" name="lastName"
                               type="text" maxlength="191" value="{{old('lastName')}}">
                        <span class="require"></span>

                    </div>

                    <div class="form-group col-sm-12">
                        <input placeholder="Email Address *" class="form-control" required="required" name="email" type="email"
                               value="{{old('email')}}" >
                        <span class="require"></span>

                    </div>

                    <div class="form-group col-sm-12">
                        <input placeholder="Password *" class="form-control pr-password"
                               pattern="(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required="required" name="password"
                               type="password" value="">
                        <span class="require"></span>

                    </div>

                    <div class="form-group col-sm-12">
                        <input data-match-error="Whoops, these don&#039;t match" placeholder="Confirm Password *"
                               data-match="#password" class="form-control" required="required"
                               name="password_confirmation" type="password" value="">
                        <span class="require"></span>

                    </div>
                    <div class="form-group col-sm-12">
                        <div class="alert alert-info">
                            Your password must contain minimum 8 characters, at least 1 uppercase alphabet, 1 lowercase
                            alphabet, 1 number and 1 special character.
                        </div>
                    </div>
                    @if(!isset($is_doctor_register))
                    <div class="form-group col-sm-12">
                        <label for="gender">Gender <span class="require-label">*</span></label>
                        <div class="inline-form">
                            <input {{old('gender') == 'm' ? 'checked' : ''}} name="gender" type="radio" value="m" id="gender">
                            <label for="Male">Male</label>
                            <input {{old('gender') == 'f' ? 'checked' : ''}} name="gender" type="radio" value="f" id="gender">
                            <label for="Female">Female</label>
                        </div>
                    </div>
                    @endif
                    <div class="form-group col-sm-6">
                        @php
                            $us = \App\Models\Country::where('code','US')->first();
                            $countries = \App\Models\Country::all();
                        @endphp
                        <select name="country" id="country" required class="form-control">
                            <option value="{{$us->id}}">{{$us->name}}</option>
                            @foreach($countries as $country)
                                @if($country->code == 'US') @continue @endif
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        <span class="require"></span>

                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="Postal Code / Zipcode *" class="form-control" required="required" name="zip"
                               type="text" value="{{old('zip')}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <select name="state" id="state" required class="form-control">
                            <option value="">State *</option>
                            @foreach(\App\Models\State::get() as $state)
                                @if(in_array($state->code,  ['NY', 'NJ', 'RI', 'MD']) && isset($is_doctor_register)) @continue @endif
                                <option {{old('state') == $state->code ? 'selected' : ''}} value="{{$state->code}}">{{$state->title}}</option>
                            @endforeach
                        </select>
                        <span class="require"></span>
                    </div>

                    <div class="form-group col-sm-6">
                        <input placeholder="City *" class="form-control" required="required" name="city" type="text" value="{{old('city')}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        <input placeholder="Street Address *" class="form-control" required="required" name="address"
                               type="text" value="{{old('address')}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="Phone *" class="form-control" required="required" name="phone" type="text"
                               value="{{old('phone')}}" >
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                    </div>
                    @if(isset($is_doctor_register))
                    <div class="col-md-12">
                        <h4 class="mt20 mb20">Doctor Information</h4>
                    </div>
                    <div class="form-group col-sm-12">
                        <input placeholder="Physician Name *" class="form-control" required="required" name="physician_name"
                               type="text" value="{{old('physician_name')}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="Physician License Number *" class="form-control" required="required" name="physician_license_number"
                               type="text" value="{{old('physician_license_number')}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="Physician NPI Number *" class="form-control" required="required" name="physician_npi_number"
                               type="text" value="{{old('physician_npi_number')}}">
                        <span class="require"></span>
                    </div>

                    <div class="form-group col-sm-12">
                        <label style="margin-bottom: 5px">Do you draw patients in your office?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="draw_patients" id="draw_patients1" value="1" @if(empty(old('draw_patients')) || old('draw_patients') == 1) checked @endif>
                            <label class="form-check-label" for="draw_patients1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="draw_patients" id="draw_patients2" value="0" @if(old('draw_patients') === 0) checked @endif>
                            <label class="form-check-label" for="draw_patients2">
                                No
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label style="margin-bottom: 5px">Do you need blood draw supplies?</label>
                        <div class="form-check ml-10">
                            <input class="form-check-input" type="radio" name="blood_draw" id="blood_draw1" value="1" @if(empty(old('blood_draw')) || old('blood_draw') == 1) checked @endif>
                            <label class="form-check-label" for="blood_draw1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="blood_draw" id="blood_draw2" value="0" @if(old('blood_draw') === 0) checked @endif>
                            <label class="form-check-label" for="blood_draw">
                                No
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <textarea class="form-control" style="min-height: 40px" placeholder="Do you have any special requests?" name="special_requests">{{old('special_request')}}</textarea>
                    </div>
                    <div class="form-group col-sm-12">
                        <small style="color: #31708f">
                            <strong>Your account will be open within the next 5 business days!</strong>
                        </small>
                    </div>
                    @endif
                    @if(!isset($is_doctor_register))
                    <div class="form-group col-sm-6">
                        <small>We do not support orders from the following states:
                            <strong>NY, NJ RI, MD</strong></small>
                    </div>
                    @endif
                    <div class="form-group col-sm-6 text-right">
                        <button type="submit" class="btn btn-flat btn-primary ">SIGNUP</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@section('script')
    <script src="{{asset('front/js/jquery.passwordRequirements.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".pr-password").passwordRequirements({
                numCharacters: 8,
                useLowercase:true,
                useUppercase:true,
                useNumbers:true,
                useSpecial:true
            });

            $('.count-doctors').each(function () {
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 3000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });
    </script>
@stop
