@php
    $productsInCart = array();
@endphp
@extends('layouts.site')
@section('css')
    <style>
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('{{ asset('/front/images/bnr-checkout.jpg') }}');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Checkout</h2>
                <h4></h4>
            </div>
        </div>
    </section>
    <form action="{{route('cart.checkoutProceed')}}" method="POST" id="payment-form">
        @csrf
        <section class="billing-area pt50">
            <div class="container">
                @include('layouts.alert')
                <div style="display: none;" class="payment-errors alert alert-danger"></div>
                <div class="address col-sm-6">
                    <div class="patient col-sm-12  fom-shad">
                        <div class="div_msg" style="padding-top: 20px;"></div>
                        <h3>
                            <mark>1</mark>
                            @if(user()->role_id == 1) Patient's @endif Information
                        </h3>
                        @if(user()->role_id == 1)
                            <div class="patient col-sm-12">
                                <input type="checkbox" name="is_different" id="is_different" value="1" {{old('is_different') ? 'checked' : ''}}>
                                <label for="is_different">Patient information different from my information.</label>
                            </div>
                            <div class="form-group container_nickname hide">
                                <div class="col-sm-8">
                                    <h5><label for="nickname">Nick name</label></h5>
                                    <input class="form-control" placeholder="Nick name" id="nickname"
                                           name="nick_name" type="text" value="{{old('nick_name','')}}">
                                </div>
                                <div class="col-sm-4" style="padding-top: 45px;">
                                    <a class="btn btn-info find_info">Find Info</a>
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-sm-6">
                            <h5><label for="firstName">First Name *</label></h5>
                            <input class="form-control" placeholder="First Name *" id="firstName" required="required"
                                   name="firstName" type="text" value="{{old('firstName','')}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <h5><label for="lastName">Last Name *</label></h5>
                            <input class="form-control" placeholder="Last Name *" id="lastName" required="required"
                                   name="lastName" type="text" value="{{old('lastName','')}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <h5><label for="email">Email *</label></h5>
                            <input class="form-control" placeholder="Email *" id="email" name="email" type="text"
                                   value="{{old('email','')}}" >
                        </div>
                        <div class="form-group col-sm-6">
                            <h5><label for="gender">Gender *</label></h5>
                            <div class="inline-form">
                                <input checked="checked" {{old('gender','')  == 'm' ? 'checked' : ''}} name="gender" type="radio" value="m" id="gender">
                                <label for="Male">Male</label>
                                <input name="gender" {{old('gender','')  == 'f' ? 'checked' : ''}} type="radio" value="f" id="gender">
                                <label for="Female">Female</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 ">
                            <label for="gender">Date of birth <span class="require-label">*</span></label>
                        </div>

                        <div class="form-group col-sm-4">
                            <select class="form-control" required="required" name="date">
                                <option value="">Day</option>
                                @for($i = 1;$i <= 31; $i++)
                                    <option  {{old('date') == $i ? 'selected' : ''}} value="{{ $i < 10 ? "0$i" : $i}}">{{ $i < 10 ? "0$i" : $i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <select class="form-control" required="required" name="month">
                                <option value="">Month</option>
                                <option {{old('month') == 1 ? 'selected' : ''}} value="01">January</option>
                                <option {{old('month') == 2 ? 'selected' : ''}} value="02">February</option>
                                <option {{old('month') == 3 ? 'selected' : ''}} value="03">March</option>
                                <option {{old('month') == 4 ? 'selected' : ''}} value="04">April</option>
                                <option {{old('month') == 5 ? 'selected' : ''}} value="05">May</option>
                                <option {{old('month') == 6 ? 'selected' : ''}} value="06">June</option>
                                <option {{old('month') == 7 ? 'selected' : ''}} value="07">July</option>
                                <option {{old('month') == 8 ? 'selected' : ''}} value="08">August</option>
                                <option {{old('month') == 9 ? 'selected' : ''}} value="09">September</option>
                                <option {{old('month') == 10 ? 'selected' : ''}} value="10">October</option>
                                <option {{old('month') == 11 ? 'selected' : ''}} value="11">November</option>
                                <option {{old('month') == 12 ? 'selected' : ''}} value="12">December</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <select class="form-control" required="required" name="year">
                                <option value="">Year</option>
                                @for($i = date('Y') - 5; $i >= date('Y') - 100; $i--)
                                    <option {{old('year') == $i ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group col-sm-12">
                            <h5><label for="Address Line 1 *">Address Line 1 *</label></h5>
                            <input class="form-control" placeholder="Street Address *" id="address" required="required"
                                   name="address" type="text" value="{{old('address','')}}">
                        </div>

                        <div class="form-group col-sm-12">
                            <h5><label for="Address Line 2">Address Line 2</label></h5>
                            <input class="form-control" placeholder="Appartment.Suite (Optional)" id="address2"
                                   name="address2" type="text" value="{{old('address2','')}}">
                        </div>
                        <div class="form-group col-sm-12 ">
                            <h5><label for="Country *">Country *</label></h5>
                            <select class="form-control" required="required" name="country_id">
                                <option>Country *</option>
                                @foreach(\App\Models\Country::get() as $country)
                                    <option {{old('country') == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6 ">
                            <h5><label for="state *">State *</label></h5>
                            <input class="form-control" placeholder="State / Region *" id="state" required="required"
                                   name="state" type="text" value="{{old('state','')}}">

                        </div>
                        <div class="form-group col-sm-6">
                            <h5><label for="city *">City *</label></h5>
                            <input class="form-control" placeholder="Town / City *" id="city" required="required"
                                   name="city" type="text" value="{{old('city','')}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <h5><label for="zip *">Zip *</label></h5>
                            <input class="form-control" placeholder="Postal Code / Zipcode *" id="zip"
                                   required="required" name="zip" type="text" value="{{old('zip','')}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <h5><label for="phone *">Phone *</label></h5>
                            <input class="form-control" placeholder="Phone *" id="phone" required="required"
                                   name="phone" type="text" value="{{old('phone','')}}">
                        </div>
                    </div>
                </div>

                <div class="col2 col-sm-6">

                    <div class="order-summary col-sm-12  fom-shad mb30">

                        <h3>
                            <mark>2</mark>
                            <span>Order Summary</span>
                            @if(user()->role_id == 1)
                                <button type="button" class="btn btn-primary" style="margin-left: 140px" data-toggle="modal" data-target="#exampleModalScrollable">
                                    Choose Tests
                                </button>
                            @endif
                        </h3>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>LAB TEST</th>
                                <th>TOTAL</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach(Cart::content() as $product)
                                @php $productsInCart[] = $product->id @endphp
                                <tr>
                                    <td>{{$product->name}} @if($product->options->type == 'bundle')(Bundle Package)@endif</td>
                                    <td>{{setting('site.currency')}}{{format_price($product->price)}}</td>
                                </tr>
                            @endforeach

                            @php $priceMandatory = 0 @endphp
                            @foreach($mandatoryProducts as $product)
                                @php
                                    $price = format_price($product->sale_price ??  $product->price);
                                    $priceMandatory += $price;
                                @endphp
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td>{{setting('site.currency')}}{{$price}}</td>
                                </tr>
                            @endforeach
                            <tr class="h4">
                                <td>Total</td>
                                <td>{{setting('site.currency')}}{{format_price(str_replace(',','',Cart::total()) + $priceMandatory)}}</td>
                                <input type="hidden" name="totalAmount" value="{{format_price(str_replace(',','',Cart::total()) + $priceMandatory)}}">
                            </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="payment-info col-sm-12  fom-shad mb30">
                        <h3>
                            <mark>3</mark>
                            Payment Information
                        </h3>
                        <div class="form-group" id="cc-group">
                            <label for="cc">Credit card number:</label>
                            <input class="form-control" required="required" data-stripe="number"
                                   data-parsley-type="number" maxlength="16" data-parsley-trigger="change focusout"
                                   data-parsley-class-handler="#cc-group" name="cc" type="text" id="cc" value="{{old('cc','')}}">

                        </div>

                        <div class="form-group" id="ccv-group">
                            <label for="CVC">CVC (3 or 4 digit number):</label>
                            <input class="form-control" required="required" data-stripe="cvc" data-parsley-type="number"
                                   data-parsley-trigger="change focusout" maxlength="4"
                                   data-parsley-class-handler="#ccv-group" name="cvc" type="text" value="{{old('cvc','')}}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="exp-m-group">
                                    <label for="expMonth">Ex. Month</label>
                                    <select class="form-control" required="required" data-stripe="exp-month" id="expMonth" name="expMonth">
                                        @for($i = 1; $i <= 12; $i++ )
                                            <option {{old('expMonth',1) == $i ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group" id="exp-y-group">
                                    <label for="expYear">Ex. Year</label>
                                    <select class="form-control" required="required" data-stripe="exp-year" id="expYear" name="expYear">
                                        @php($year = \Carbon\Carbon::now()->year)
                                        @for($i = $year; $i <= $year+10;$i++)
                                            <option {{old('expYear',1) == $i ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-info col-sm-12 fom-shad mb30">
                        <div class="form-group">
                            <h3>
                                <mark>4</mark>
                                <label for="message" style="font-weight: 500">Additional Message</label>
                            </h3>
                            <textarea class="form-control" id="message" name="message" cols="105" rows="7">{{old('message','')}}</textarea>

                        </div>
                        <div class="terms col-sm-12">
                            <div style="display: none;" class="terms-errors alert alert-danger">
                            </div>
                            <input type="checkbox" name="terms" id="terms" {{old('terms') == 1 ? 'checked' : ''}} value="1" $required="">
                            I accept the <a target="_black" href="https://newcenturylabs.com/terms">Terms of Service</a>.
                        </div>
                        <div class="form-group col-sm-12 p0 mb30">
                            @if(user()->role_id == 1)
                                <button id="place_order" class="form-control btn-primary w100">PLACE ORDER</button>
                            @else
                                <button id="place_order" class="form-control btn-primary w100">PLACE ORDER</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document" style="top: 10% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  id="exampleModalScrollableTitle">Check off order items </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 600px;overflow-x: hidden;overflow-y: scroll">
                    <table class="table table-bordered table-dark">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Test Code</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productsAvailable as $productAvailable)
                            <tr>
                                <th><input type="checkbox" name="ids" @if(in_array($productAvailable->id,$productsInCart)) checked @endif class="confirm_test" value="{{$productAvailable->id}}"></th>
                                <td>{{$productAvailable->name}}</td>
                                <td>{{$productAvailable->code}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submit_order" disabled>Add to Order</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://js.stripe.com/v2/"></script>
    <link href="{{asset('front\plugin\select2\css\select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('front\plugin\select2\js\select2.min.js')}}"></script>
    <script>
        var mandatoryProducts = `<?php echo json_encode($mandatoryProducts) ?>`.toString();
        $("[name=country_id]").select2({});
        var turnOnLoading =  function (){
            $('.loader').removeClass('hidden');
            $('main').addClass('isLoading');
            $('.hdr-nav').addClass('isLoading');
        }

        var turnOffLoading = function (){
            $('.loader').addClass('hidden');
            $('main').removeClass('isLoading');
            $('.hdr-nav').removeClass('isLoading');
        }

        Stripe.setPublishableKey('{{env('STRIPE_SECRET_PK')}}');
        function check_terms_services() {
            var terms = jQuery("#terms").prop("checked");
            if (terms === false) {
                let termSelector = $('.terms-errors');
                termSelector.show();
                termSelector.text('Please accept our terms of service.');
                termSelector.addClass('alert alert-danger');
                return false;
            }

        }
        @if(user()->role_id == 1)
            let priceMandatory = parseInt(`{{$priceMandatory}}`);
            $('.confirm_test').on('click',function (e){
                let totalItem = $('.confirm_test').length;
                if($('.confirm_test:checked').length > 0){
                    $("#submit_order").prop('disabled',false);
                }else{
                    $("#submit_order").prop('disabled',true);
                }
            })
            $('#submit_order').on('click',function (e){
                e.preventDefault();
                $('#exampleModalScrollable').modal('hide');
                turnOnLoading();
                let ids = [];
                $('[name=ids]:checked').each(function () {
                    ids.push($(this).val());
                });
                $.ajax({
                    url: "{{route('drAddTests')}}",
                    data : {
                        '_token' : '{{csrf_token()}}',
                        'ids' : ids,
                    },
                    success: function(result){
                        let html = "";
                        $.each(result.cart, function (key, val) {
                            html += `<tr>
                                        <td>${val.name}</td>
                                        <td>$${Number.isInteger(val.price) ? val.price : val.price.toFixed(2)}</td>
                                    </tr>`;
                        });

                        $.each(JSON.parse(mandatoryProducts.toString()),function (key,val){
                            let price = 0;
                            if(val.sale_price != null){
                                price = parseFloat(val.sale_price);
                            }else{
                                price = parseFloat(val.price);
                            }
                            html += `<tr>
                                        <td>${val.name}</td>
                                        <td>$${Number.isInteger(price) ? Number(price) : Number(price).toFixed(2)}</td>
                                    </tr>`;
                        })

                        var totalCart = Number(result.cart_total) + Number(priceMandatory);
                        html += `<tr class="h4">
                                        <td>Total</td>
                                        <td>$${Number.isInteger(parseFloat(totalCart)) ? parseFloat(totalCart) : totalCart.toFixed(2)}</td>
                                        <input type="hidden" name="totalAmount" value="${Number.isInteger(parseFloat(totalCart)) ? parseFloat(totalCart) : totalCart.toFixed(2)}">
                                    </tr>`;
                        $('.order-summary').find('tbody').html(html);
                        turnOffLoading();
                    }});
            });
        @endif
        $('#payment-form').submit(function (event) {
            $('.terms-errors').hide();
            $('.payment-errors').hide();
            var term = check_terms_services();
            if (term === false) {
                return false;
            }

            var form = $('#payment-form');
            form.find('#place_order').prop('disabled', true);
            Stripe.card.createToken(form, stripeResponseHandler);
            return false;
        });


        function stripeResponseHandler(status, response) {
            // Grab the form:
            var $form = $('#payment-form');
            if (response.error) { // Problem!
                // Show the errors on the form
                $form.find('.payment-errors').show();
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false); // Re-enable submission

                var scrollPos = $form.offset().top;
                $(window).scrollTop(scrollPos);
            } else { // Token was created!

                // Get the token ID:
                var token = response.id;

                // Insert the token into the form so it gets submitted to the server:
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                // Submit the form:
                $form.get(0).submit();
            }
        }


        $("#firstName").val('{{ old('firstName',$user->firstName ?? '') }}');
        $("#lastName").val('{{ old('lastName',$user->lastName ?? '') }}');
        $("#email").val('{{ old('email',$user->email ?? '') }}');
        $("#address").val('{{ old('address',$address['billing']->address ?? '') }}');
        $("#address2").val('{{ old('address2',$address['billing']->address2 ?? '') }}');
        $("#state").val('{{ old('state',$address['billing']->state ?? '') }}');
        $("#city").val('{{ old('city',$address['billing']->city ?? '') }}');
        $("#zip").val('{{ old('zip',$address['billing']->zip ?? '')}}');
        $("#phone").val('{{ old('phone',$address['billing']->phone ?? '') }}');
        $("[name=country_id]").val('{{ old('country_id',$address['billing']->country_id)}}').trigger('change');
        $('#gender[value="{{ old('gender',$user->gender ?? 'm')  }}"]').prop("checked",true);
        $("#is_different").on("change", function () {
            if ($("#is_different").is(':checked')) {
                $('.container_nickname').removeClass('hide');
                $("#firstName").val('');
                $("#lastName").val('');
                $("#email").val('');
                $("#address").val('');
                $("#address2").val('');
                $("#state").val('');
                $("#city").val('');
                $("#zip").val('');
                $("#phone").val('');
                $("[name=country_id]").val('').trigger('change');
                $('#gender[value="m"]').prop("checked",true);
            } else {
                $('.container_nickname').addClass('hide');
                $("#firstName").val('{{ $user->firstName ?? '' }}');
                $("#lastName").val('{{ $user->lastName ?? '' }}');
                $("#email").val('{{ $user->email ?? '' }}');
                $("#address").val('{{ $address['billing']->address ?? '' }}');
                $("#address2").val('{{ $address['billing']->address2 ?? '' }}');
                $("#state").val('{{ $address['billing']->state ?? '' }}');
                $("#city").val('{{ $address['billing']->city ?? '' }}');
                $("#zip").val('{{ $address['billing']->zip ?? '' }}');
                $("#phone").val('{{ $address['billing']->phone ?? '' }}');
                $("[name=country_id]").val('{{$address['billing']->country_id }}').trigger('change');
                $('#gender[value="{{ $user->gender }}"]').prop("checked",true);
            }
        });

        $('.find_info').on('click',function (){
            let nickname = $('#nickname').val();
            if(nickname.length == 0){
                $('#nickname').css('border','1px solid red');
            }else{
                $.ajax({
                    url: "{{route('findOldInfoByNickname')}}",
                    data : {
                        '_token' : '{{csrf_token()}}',
                        'nick_name' : nickname,
                    },
                    success: function(result){
                        if (result.status == 'success'){
                            let data = result.data;
                            $('.div_msg').html(``);
                            $("#firstName").val(data.firstName);
                            $("#lastName").val(data.lastName);
                            $("#email").val(data.email);
                            $("#address").val(data.address);
                            $("#address2").val(data.address2);
                            $("#state").val(data.state);
                            $("#city").val(data.city);
                            $("#zip").val(data.zip);
                            $("#phone").val(data.phone);
                            $("[name=country_id]").val(data.country_id).trigger('change');
                            $('#gender[value="'+data.gender+'"]').prop("checked",true);

                            $('#nickname').css('border','1px solid #ccc');
                        }else{
                            $('.div_msg').html(`<div class="alert alert-danger" role="alert">
                              Could not find information related to nick name!
                            </div>`);
                        }
                }});
            }

        });
    </script>
@endsection
