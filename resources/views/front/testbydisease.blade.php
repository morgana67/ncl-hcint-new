@extends('layouts.site')
@section('title'){{ 'Test Menu' }}@endsection
@section('description'){{'Test By Disease'}}@endsection
@section('keywords'){{'Test By Disease'}}@endsection
@section('content')
    <section class="bnr-area page-bnr-area bg-full bg-cntr valigner" style="background-image:url('{{ asset('front/images/testmenu2.jpg') }}');">
        <div class="container">
            <div class="bnr__cont valign white text-center col-sm-12 text-uppercase anime-flipInX">
                <h2>Disease Category</h2>
                <h4>INFORMATION ABOUT “YOU” WHEN YOU WANT IT!</h4>
            </div>
        </div>
    </section>

    <section class="test-bd-area pt50 pb50" >
        <div class="container">
            <p>We all have health concerns, and sometimes, linking symptoms with blood tests can be challenging.  We’re making it easier to help you search and group blood tests by specific health concerns with our new blood tests by disease search.</p>
            <div class="test-menu-area table-responsive0">

                <h3>Health Concerns</h3>

                <style>
                    td[colspan] {
                        font-size: 28px;
                    }
                </style>

                <table id="example" class="table table-area0 table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="col-sm-8">Disease category</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Disease category</th>
                    </tr>
                    </tfoot>
                    <tbody>


                    @foreach($diseaseTypes as $element)
                    <tr>
                        <td><a href="{{route('testlistbydisease',['id' => $element->id])}}">{{$element->name}}</a>
                            <a class="btn btn-view pul-rgt" href="{{route('testlistbydisease',['id' => $element->id])}}">View</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
