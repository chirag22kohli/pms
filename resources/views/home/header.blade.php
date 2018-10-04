<header id="navbar-spy" class="header header-1 header-transparent header-bordered header-fixed">
    <nav id="primary-menu" class="navbar navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="logo" href="{{ url('/') }}">
                    <img class="logo-dark" src="{{ asset('home/images/logo/logo-dark.png') }}" alt="appy Logo">
                    <img class="logo-light" src="{{ asset('home/images/logo/logo-light.png') }}" alt="appy Logo">
                </a>
            </div>
            <div class="collapse navbar-collapse pull-right" id="navbar-collapse-1">
                <ul class="nav navbar-nav nav-pos-right navbar-left nav-split">
                    <li class="active"><a data-scroll="scrollTo" href="{{ url('/') }}">home</a>
                    </li>
                    <li><a data-scroll="scrollTo" href="#feature2">feature</a>
                    </li>
                    <li><a data-scroll="scrollTo" href="#video">video</a>
                    </li>
                    <li><a data-scroll="scrollTo" href="#screenshots">screenshots</a>
                    </li>
                    <li><a data-scroll="scrollTo" href="#reviews">reviews</a>
                    </li>
                    <li><a data-scroll="scrollTo" href="#pricing">pricing</a>
                    </li>
                    <li><a data-scroll="scrollTo" href="#cta">download</a>
                    </li>
                    @if (Route::has('login'))
                   
                        @auth
                        <li><a data-scroll="scrollTo" href="{{ url('/home') }}">Dashboard</a></li>

                        @else
                        <li><a data-scroll="scrollTo" href="{{ route('login') }}">Login</a></li>
                        <li><a data-scroll="scrollTo" href="#pricing">Register</a>
                        </li>

                        @endauth
                   
                    @endif
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
</header>