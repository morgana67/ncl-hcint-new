@extends('layouts.site')

@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('front/images/bnr-signup.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2></h2>
                <h4></h4>
            </div>
        </div>
    </section>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{route('postRegister')}}" class="form" name="register">
        @csrf
        <section class="billing-area ">
            <div class="container">
                <div class="fom fom-shad pt20 col-sm-9 p0 pul-cntr">
                    <div class="form-group col-sm-12">
                        <input placeholder="Email *" class="form-control" required="required" name="email" type="email"
                               value="{{old('email')}}" >
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
