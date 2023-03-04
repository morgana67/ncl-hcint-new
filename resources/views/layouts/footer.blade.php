<footer>
    <section class="ftr-area bg-gray white">
        <div class="container">
            {!! menu('Menu Footer','menu_footer') !!}
            <div class="ftr__box shake-icon col-sm-4 social-area icon-boxed icon-rounded clrlist listview ">
                <h4>Stay Connected</h4>
                <ul>
                    <li><a href="{{setting('site.link_facebook')}}" target="_black"><i
                                class="fa fa-facebook"></i> Like us on Facebook</a></li>
                    <li><a href="{{setting('site.link_twitter')}}" target="_black"><i class="fa fa-twitter"></i>
                            Follow us on Twitter</a></li>
                    <li><a href="{{setting('site.link_youtube')}}" target="_black"><i
                                class="fa fa-youtube-play"></i> Subscribe our Youtube page</a></li>

                </ul>
            </div>
        </div>

    </section>
    <section class="bottom-area bg-gray white text-center clrlist p10">
        <div class="container">
        <span>{{setting('site.copy_right')}}</span>
            <div class="bottom__links clrlist listdvr">
                <ul>
                    <li><a href="{{route('privacy')}}">Privacy</a></li>
                    <li><a href="{{route('terms')}}">Terms</a></li>
                    <li><a href="{{route('credits')}}">Site Credits</a></li>
                </ul>
            </div>
        </div>
    </section>
</footer>
<form class="logout-form" action="{{route('logout')}}" method="POST">
    @csrf
</form>

