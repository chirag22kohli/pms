
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Chap Augumented Reality</title>
        <!-- Meta Tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta name="keywords" content="Chap Augumented Reality" />
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
        <!--// Fontawesome Css -->
        <!--// Style-sheets -->

        <!--web-fonts-->
        <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!--//web-fonts-->
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.material.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <style>
            .col-md-9{
                width:100% !important;
                flex: 0 0 100%;
                max-width: 100%;
            }
        </style>
    </head>

    <body>
        <div class="wrapper">

            @include('client.sidebar')
            <div id="content">
                @include('client.header')
                @if (Session::has('flash_message'))
                <div class="container">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('flash_message') }}
                    </div>
                </div>
                @endif

                @yield('content')

                @include('client.footer')
            </div>
        </div>

        <!-- Required common Js -->
        <script src='{{ asset('js/client/jquery-2.2.3.min.js') }} '></script>
        <!-- //Required common Js -->

        <!-- Sidebar-nav Js -->
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
        <!-- //dropdown nav -->

        <!-- Js for bootstrap working-->
        <script src="{{ asset('js/client/bootstrap.min.js') }}"></script>
        <!-- //Js for bootstrap working -->
        <script src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js '></script>


        <script src='{{ asset('js/client/script.js') }} '></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

        <script src="{{ asset('js/client/jquery-lang.js') }} "></script>
        <script type="text/javascript">
            // Create language switcher instance
            var lang = new Lang();
            lang.dynamic('th', 'th.json');
            lang.init({
            /**
             * The default language of the page / app.
             * @type String
             * @required 
             */
            defaultLang: 'en',
                    /**
                     * The current language to set the page to.
                     * @type String
                     * @optional 
                     */
                    currentLang: 'en',
                    /**
                     * This object is only required if you want to override the default
                     * settings for cookies.
                     */
                    cookie: {
                    /**
                     * Overrides the default cookie name to something else. The default
                     * is "langCookie".
                     * @type String
                     * @optional
                     */
                    name: 'langCookie',
                            expiry: 365,
                            path: '/'
                    },
                    /**
                     * If true, cookies will override the "currentLang" option if the
                     * cookie is set. You usually shouldn't need to specify this option
                     * at all unless your JavaScript lang.init() method is being
                     * dynamically generated by PHP or other server-side processor.
                     * @type Boolean
                     * @optional 
                     */
                    allowCookieOverride: true
            });
        </script> 
    </body>

</html>
