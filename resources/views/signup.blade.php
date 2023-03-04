@extends('layouts.site')
@section('content')
    <section class="box-area text-center  pt20 pb50">
        <section class="inr-bnr-blank">
            <div class="container">
                <div class="hed"><h2>LOGIN</h2></div>
            </div>
        </section>

        <section class="inr-intro-area ">
            <div class="container">

                <div class="fom col-sm-6 fom-shad pt20">
                    <form method="POST" class="form" action="">
                        <input type="hidden" name="_token" value="eXCobM3GVbblofigprE2vU9ciECwU3OdyOd2obbV">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required/>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password"
                                   required/>
                        </div>

                        <div class="form-group mb10 overload">
                            <div class="checkbox-area pul-lft">
                                <input type="checkbox" class="checkbox" name="remember"><label>Remember Me</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button ype="submit" class="form-control w100 btn-primary">LOGIN</button>
                        </div>
                    </form>
                    <a href="forgot.html" class="link pul-lft">
                        <i class="fa fa-support"></i>Lost your passward?
                    </a>
                </div>
                <div class="cont text-center col-sm-6 pl50 pr50">
                    <h2>REGISTER</h2>
                    <p>Registering allows you to order tests. Just fill in the fields and we’ll get you ready to go in
                        no time. We will only ask you for information that allows us to prepare your lab order.</p>
                    <div class="lnk-btn "><a href="register.html">REGISTER</a></div>
                </div>
            </div>
        </section>
    </section>
@endsection
