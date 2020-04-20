<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-script-type" content="text/javascript" />
        <meta http-equiv="content-style-type" content="text/css" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            addEventListener("load", function () {
                setTimeout(hideURLbar, 0);
            }, false);
            function hideURLbar() {
                window.scrollTo(0, 1);
            }
        </script>
        <!-- //Meta Tags -->

        <!-- Style-sheets -->
        <!-- Bootstrap Css -->
        <link href="{{ asset('css/client/bootstrap.css') }} " rel="stylesheet" type="text/css" media="all" />
        <!-- Bootstrap Css -->
        <!-- Common Css -->
        <link href="{{ asset('css/client/style.css') }} " rel="stylesheet" type="text/css" media="all" />
        <!--// Common Css -->
        <!-- Nav Css -->
        <link rel="stylesheet" href="{{ asset('css/client/style4.css') }}">
        <!--// Nav Css -->
        <!-- Fontawesome Css -->
        <link href="{{ asset('css/client/fontawesome-all.css') }} " rel="stylesheet">
        <link href="{{ asset('css/client/widgets.css') }} " rel="stylesheet">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
        <script type="text/javascript">
            var $j = jQuery.noConflict(true);
        </script>
        <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <link href="{{ asset('css/ar/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <!-- Updated stylesheet url -->
        <link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">

        <!-- Updated JavaScript url -->
        <script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
        <script>
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            });
        </script>
        <!--// Sidebar-nav Js -->

        <!-- dropdown nav -->
        <script>
            $(document).ready(function () {
                $(".dropdown").hover(
                        function () {
                            $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                            $(this).toggleClass('open');
                        },
                        function () {
                            $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                            $(this).toggleClass('open');
                        }
                );
            });
        </script>
    </head>
    <body style="    min-height: 800px;" >
        <div id="app">



            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <h1>
                            <a href="{{url('homepage')}}">Chap   <i class="fab fa-connectdevelop"></i></a>
                        </h1>
                    </div>
                    <!-- Search-from
                    <form action="#" method="post" class="form-inline mx-auto search-form">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" required="">
                        <button class="btn btn-style my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <!--// Search-from -->
                    <ul class="top-icons-agileits-w3layouts float-right">


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="far fa-user"></i>
                            </a>
                            <div class="dropdown-menu drop-3" style="left: unset">
                                <div class="profile d-flex mr-o">
                                    <div class="profile-l align-self-center">
                                      <!--  <img src="images/profile.jpg" class="img-fluid mb-3" alt="Responsive image"> -->
                                    </div>
                                    <div class="profile-r align-self-center">
                                        <h3 class="sub-title-w3-agileits">    {{ Auth::user()->name }}</h3>
                                        <a href="mailto:{{ Auth::user()->email }}">    {{ Auth::user()->email }}</a>
                                    </div>
                                </div>
                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-user mr-3"></i>My Profile</h4>
                                </a>

                                <a href="#" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-question-circle mr-3"></i>Faq</h4>
                                </a>
                                <a href="{{url('client/newPaymentMethod')}}" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-stripe-s mr-3"></i>Add New Payment Method</h4>
                                </a>
                                <a href="{{url('client/support')}}" class="dropdown-item mt-3">
                                    <h4>
                                        <i class="far fa-thumbs-up mr-3"></i>Support</h4>
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>


            <main class="py-4">
                @yield('content')
            </main>
        </div>

        <!-- Scripts -->

    </body>
</html>
