<header>
    <section class="hdr-area hdr-nav hdr--sticky blur-nav--hover0 cross-toggle fixed">
        <div class="container">
            <nav class="navbar navbar-default" role="navigation" id="slide-nav">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="/" class="navbar-brand">
                            <img src="{{image(setting('site.logo'))}}" alt="Logo"/>
                        </a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div id="slidemenu">
                        <div>
                            {!! menu('Menu Header','menu_header') !!}
                        </div><!-- /.navbar-collapse -->
                    </div>
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </section>
</header>
