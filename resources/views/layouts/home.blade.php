<!DOCTYPE html>
<html dir="ltr" lang="en-US">

    <head>
        <!-- Document Meta
    ============================================= -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--IE Compatibility Meta-->
        <meta name="author" content="zytheme"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Chap Augmented Reality">
        <link href="{{ asset('home/images/favicon/favicon.png') }}" rel="icon">

        <!-- Fonts
    ============================================= -->
        <link href='http://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i,800,800' rel='stylesheet' type='text/css'>

        <!-- Stylesheets
    ============================================= -->
        <link href="{{ asset('home/css/external.css') }}" rel="stylesheet">
        <link href="{{ asset('home/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('home/css/style.css') }} " rel="stylesheet">


        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

        <!-- Document Title
    ============================================= -->
        <title>Welcome To Chap</title>
    </head>

    <body class="body-scroll">
        <!-- Document Wrapper
        ============================================= -->
        <div id="wrapper" class="wrapper clearfix">
            @include('home.header')


            @yield('content')
            <footer id="footer" class="footer footer-5">
                <!-- Copyrights
                ============================================= -->
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text--center">
                            <div class="footer--copyright">
                                <span>&copy; 2018 Chap, crafted With <i class="fa fa-heart"></i> </span> 

                            </div>
                        </div>
                    </div>
                </div>
                <!-- .container end -->
            </footer>
        </div>
        <!-- #wrapper end -->

        <!-- Footer Scripts
        ============================================= -->
        <script src="{{ asset('home/js/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('home/js/plugins.js') }}"></script>
        <script src="{{ asset('home/js/functions.js') }} "></script>
    </body>
</html>