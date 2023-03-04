@extends('layouts.site')

@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url({{asset('front/images/bnr-signup.jpg')}});margin-bottom: 50px">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Reset Password</h2>
            </div>
        </div>
    </section>

    <form method="POST" action="{{route('resetPassword')}}" class="form pt-3" name="register" style="margin-bottom: 50px">
        @csrf
        <section class="billing-area ">
            <div class="container">
                <div class="fom col-sm-6 fom-shad pt20 p0 pul-cntr">
                    <div class="col-md-12">

                        @include('layouts.alert')
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="alert alert-info">This page is for Customers & Doctors only to recover their passwords. If you are an administrator <a href="{{url('/admin/forgot-password')}}" style="text-decoration: underline">click here</a> to recover your password.</div>
                        <input placeholder="Email *" class="form-control" required="required" name="email" type="email"
                               value="{{old('email')}}" >
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                            <button type="submit" class="form-control w100 btn-primary">RESET PASSWORD</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
