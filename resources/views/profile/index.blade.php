@php
    use Carbon\Carbon as Carbon;
@endphp
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
            font-size: 36px;
            position: absolute;
            top: -10px;
            color: red;
        }
    </style>
@stop

@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('front/images/bnr-signup.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Profile</h2>
                <h4></h4>
            </div>
        </div>
    </section>

    <form method="POST" action="{{route('profile.profile')}}" class="form" name="register">
        @csrf
        <section class="billing-area ">
            <div class="container">

                <div class="fom fom-shad pt20 col-sm-9 p0 pul-cntr">
                    <div class="col-md-12">
                        @include('layouts.alert')
                        <h4 class="mt20 mb20">User Information</h4>
                    </div>
                    <div class="form-group col-sm-6">
                        <input placeholder="First Name *" class="form-control" required="required" name="firstName"
                               type="text" value="{{old('firstName',$user->firstName)}}">
                        <span class="require"></span>

                    </div>

                    <div class="form-group col-sm-6">
                        <input placeholder="Last Name *" class="form-control" required="required" name="lastName"
                               type="text" maxlength="191" value="{{old('lastName',$user->lastName)}}">
                        <span class="require"></span>

                    </div>

                    <div class="form-group col-sm-12">
                        <input placeholder="Email *" class="form-control" required="required" name="email"
                               type="text" value="{{old('email',$user->email)}}">
                        <span class="require"></span>

                    </div>
                    @if($user->role_id != 1)
                    <div class="form-group col-sm-12 clrhm">
                        <label for="gender">Gender <span class="require-label">*</span></label>
                        <div class="inline-form">
                            <input {{old('gender',$user->gender) == 'm' || empty(old('gender')) ? 'checked' : ''}} name="gender" type="radio" value="m" id="gender">
                            <label for="Male">Male</label>
                            <input {{old('gender',$user->gender) == 'f' ? 'checked' : ''}} name="gender" type="radio" value="f" id="gender">
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
                               type="text" value="{{old('zip',$user->address->zip)}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                        <select name="state" id="state" required class="form-control">
                            <option>State *</option>
                            @foreach(\App\Models\State::get() as $state)
                                @if(in_array($state->code,  ['NY', 'NJ', 'RI', 'MD']) && isset($is_doctor_register)) @continue @endif
                                <option {{old('state',$user->address->state) == $state->code ? 'selected' : ''}} value="{{$state->code}}">{{$state->title}}</option>
                            @endforeach
                        </select>
                        <span class="require"></span>
                    </div>

                    <div class="form-group col-sm-6">
                        <input placeholder="City *" class="form-control" required="required" name="city" type="text" value="{{old('city',$user->address->city)}}">
                        <span class="require"></span>
                    </div>


                    <div class="form-group col-sm-12">
                        <input placeholder="Address *" class="form-control" required="required" name="address"
                               type="text" value="{{old('address',$user->address->address)}}">
                        <span class="require"></span>
                    </div>

                    <div class="form-group col-sm-6">
                        <input placeholder="Phone *" class="form-control" required="required" name="phone" type="text"
                               value="{{old('phone',$user->address->phone)}}" >
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-6">
                    </div>

                    <div class="form-group col-sm-4">
                        <input placeholder="Facebook" class="form-control" name="facebook"
                               type="text" maxlength="191" value="{{old('facebook',$user->facebook)}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-4">
                        <input placeholder="Twitter" class="form-control" name="twitter"
                               type="text" maxlength="191" value="{{old('twitter',$user->twitter)}}">
                        <span class="require"></span>
                    </div>
                    <div class="form-group col-sm-4">
                        <input placeholder="Instagram" class="form-control" name="instagram"
                               type="text" maxlength="191" value="{{old('instagram',$user->instagram)}}">
                        <span class="require"></span>
                    </div>

                    @if($user->role_id == 1)
                        <div class="col-md-12">
                            <h4 class="mt20 mb20">Doctor Information</h4>
                        </div>
                        <div class="form-group col-sm-12">
                            <input placeholder="Physician Name*" class="form-control" required="required" name="physician_name"
                                   type="text" value="{{old('physician_name', $user->physician_name)}}">
                            <span class="require"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <input placeholder="Physician License Number*" class="form-control" required="required" name="physician_license_number"
                                   type="text" value="{{old('physician_license_number', $user->physician_license_number)}}">
                            <span class="require"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <input placeholder="Physician NPI Number*" class="form-control" required="required" name="physician_npi_number"
                                   type="text" value="{{old('physician_npi_number', $user->physician_npi_number)}}">
                            <span class="require"></span>
                        </div>

                        <div class="form-group col-sm-12">
                            <label style="margin-bottom: 5px">Do you draw patients in your office?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="draw_patients" id="draw_patients1" value="1" @if(empty(old('draw_patients', $user->draw_patients)) || old('draw_patients', $user->draw_patients) == 1) checked @endif>
                                <label class="form-check-label" for="draw_patients1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="draw_patients" id="draw_patients2" value="0" @if(old('draw_patients', $user->draw_patients) === 0) checked @endif>
                                <label class="form-check-label" for="draw_patients2">
                                    No
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label style="margin-bottom: 5px">Do you need blood draw supplies?</label>
                            <div class="form-check ml-10">
                                <input class="form-check-input" type="radio" name="blood_draw" id="blood_draw1" value="1" @if(empty(old('blood_draw', $user->blood_draw)) || old('blood_draw', $user->blood_draw) == 1) checked @endif>
                                <label class="form-check-label" for="blood_draw1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="blood_draw" id="blood_draw2" value="0" @if(old('blood_draw', $user->blood_draw) === 0) checked @endif>
                                <label class="form-check-label" for="blood_draw">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <textarea class="form-control" style="min-height: 40px" placeholder="Do you have any special requests?" name="special_requests">{{old('special_requests', $user->special_requests)}}</textarea>
                        </div>
                    @endif
                    @if(!isset($is_doctor_register))
                    <div class="form-group col-sm-6">
                        <small>We do not support orders from the following states:
                            <strong>NY, NJ RI, MD</strong></small>
                    </div>
                    @endif
                    <div class="form-group col-sm-6 text-right">
                        <button type="submit" class="btn btn-flat btn-primary ">UPDATE PROFILE</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
