@extends('layouts.site')
@section('css')
    <link rel="stylesheet" href="{{asset('front/css/jquery.passwordRequirements.css')}}">
@stop
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url({{asset('front/images/bnr-signup.jpg')}});margin-bottom: 50px">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Change Password</h2>
            </div>
        </div>
    </section>

    <form method="POST" action="{{route('changePassword')}}" class="form pt-3" name="register" style="margin-bottom: 50px">
        @csrf
        <section class="billing-area ">
            <div class="container">
                <div class="fom col-sm-6 fom-shad pt20 p0 pul-cntr">
                    @csrf
                    <div class="col-md-12">
                        @include('layouts.alert')
                    </div>
                    <input type="hidden" name="token" value="{{!empty(request()->get('token')) ? request()->get('token') : ''}}">
                    <div class="form-group col-sm-12">
                        <input placeholder="Password *" class="form-control pr-password" required="required" name="password"
                               type="password" value="" min="8">
                    </div>

                    <div class="form-group col-sm-12">
                        <input data-match-error="Whoops, these don&#039;t match" placeholder="Confirm Password *"
                               data-match="#password" class="form-control" required="required"
                               name="password_confirmation" min="8" type="password" value="">
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="alert alert-info">
                            Your password must contain minimum 8 characters, at least 1 uppercase alphabet, 1 lowercase
                            alphabet, 1 number and 1 special character.
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <button type="submit" class="form-control w100 btn-primary">CHANGE PASSWORD</button>
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

        });
    </script>
@stop
