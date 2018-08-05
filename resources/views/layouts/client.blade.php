
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
        <!--// Fontawesome Css -->
        <!--// Style-sheets -->

        <!--web-fonts-->
        <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!--//web-fonts-->
    </head>

    <body>
        <div class="wrapper">

            @include('client.sidebar')
            <div id="content">
                @include('client.header')
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

    </body>

</html>
