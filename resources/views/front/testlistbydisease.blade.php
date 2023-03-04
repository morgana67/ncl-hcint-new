@extends('layouts.site')
@section('title'){{ $disease->name }}@endsection
@section('description'){{ $disease->description }}@endsection
@section('keywords'){{ $disease->title }}@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('../front/images/testmenu2.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Test Menu</h2>
                <h4>INFORMATION ABOUT “YOU” WHEN YOU WANT IT!</h4>
            </div>
        </div>
    </section>
    <section class="test-bd-area pt50 pb50">
        <div class="container">
            <p>Traditionally to order a lab test you have to make an appointment to see your doctor, wait in clinic
                waiting
                room with other sick patients, pay your copay, pay the doctors fee and get a surprise bill in the mail,
                why
                would you want to go through the stress? Browse our test menu and order on demand, on your terms, it’s
                the
                21st century.</p>
            <div class="test-menu-area table-responsive0">

                <div class="row">
                    <div class="col-sm-10"><h3 style="margin-bottom: 22px;">{{ucfirst($disease->name)}}<br></h3>

                    </div>
                    <div class="col-sm-2" style="padding-left: 65px;">
                        <button id="btn_add_to_cart_all" class="out-btn btn btn-default"
                                style="margin-top: 12px;background-color: #0076c4;color: white;" disabled>CHECKOUT
                        </button>
                    </div>



                </div>
                <style>
                    td[colspan] {
                        font-size: 28px;
                    }
                </style>

                <table id="example" class="table table-area0 table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="col-sm-2">Quest Test Codes</th>
                        <th class="col-sm-8">Tests Names</th>
                        <th class="col-sm-2">Select All
                            <input type="checkbox" name="" id="checkAll" value="0" style="margin-left: 10px;">
                        </th>
                    </tr>
                    </thead>

                    <tbody>

                    <form action="{{route('cart.addMultiple')}}" method="POST" id="addMultiple">
                        @csrf
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->code}}</td>
                                <td>
                                    <a href="{{ route('product_detail',['slug' => $product->slug]) }}">{{$product->name}}</a>
                                    <a class="btn btn-view pul-rgt" href="{{ route('product_detail',['slug' => $product->slug])}}">View</a>
                                </td>
                                <td>
                                    <input type="checkbox" name="product_id[]" value="{{$product->id}}" style="margin-left: 85px;"/>
                                </td>
                            </tr>
                        @endforeach
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        var btn = $('#btn_add_to_cart_all');

        $('#checkAll').on('click',function () {
            if($(this).is(":checked")){
                $('[name="product_id[]"]').prop('checked', true);
                btn.prop('disabled', false);
            }else{
                $('[name="product_id[]"]').prop('checked', false);
                btn.prop('disabled', true);
            }
        })

        $('[name="product_id[]"]').on('click',function () {
            if($('[name="product_id[]"]:checked').length > 0){
                btn.prop('disabled', false);
            }else{
                btn.prop('disabled', true);
            }
        })

        btn.on('click',function () {
            if($('[name="product_id[]"]:checked').length > 0){
                $('form#addMultiple').submit();
            }else{
                btn.prop('disabled', true);
            }
        })
    </script>
@endsection
