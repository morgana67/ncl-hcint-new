@extends('layouts.site')
@section('title'){{ 'Test Menu' }}@endsection
@section('description'){{'Shop'}}@endsection
@section('keywords'){{'Shop'}}@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner"
             style="background-image:url('front/images/testmenu2.jpg');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Test Menu</h2>
                <h4>INFORMATION ABOUT “YOU” WHEN YOU WANT IT!</h4>
            </div>
        </div>
    </section>
    <section class="test-bd-area pt50 pb50">
        <div class="container">
            <p>Traditionally, to order a blood test, you have to make an appointment to see your doctor, then wait in
                the clinic waiting room with other sick patients, then pay your copay, pay the doctor's fee, and on top
                of everything, get a surprise bill in the mail for your lab work. Why would you want to go through all
                that stress when you can do everything right here, right now? Browse our test menu to order blood tests
                on demand, on your terms - no surprises, just results.</p>
            <div class="test-menu-area table-responsive0">

                <h3>Test Menu</h3>
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
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Quest Test Codes</th>
                        <th>Name</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($products as $alphabet => $ps)
                        <tr>
                            <td colspan="4">{{$alphabet}}</td>
                        </tr>
                        @foreach($ps as $product)

                            <tr>
                                <td>{{ $product->code }}</td>
                                <td><a href="{{route('product_detail',['slug' => $product->slug])}}">{{ $product->name }}</a>
                                    <a class="btn btn-view pul-rgt"
                                       href="{{route('product_detail',['slug' => $product->slug])}}">View</a></td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
