<!DOCTYPE html>
<html>
    <head>
        <title>Chap Signup</title>
        <!-- custom-theme -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Chap Augumented Reality" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //custom-theme -->
        
        <link href="{{ asset('css/clientsignup/style.css') }}" rel="stylesheet" type="text/css" media="all" />
        <!-- js -->
        <script type="text/javascript" src="{{ asset('js/clientsignup/jquery-2.1.4.min.js') }}"></script>
        <!-- //js -->
        <link href="{{ asset('css/clientsignup/popup-box.css') }}" rel="stylesheet" type="text/css" media="all" />
        <!-- font-awesome icons -->
        <link href="{{ asset('css/clientsignup/font-awesome.css') }} " rel="stylesheet"> 
        <!-- //font-awesome icons -->
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <link href=" https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
       
    </head>
    <body>
        @yield('content')
        <!-- Scripts -->


        <script type="text/javascript">
            window.onload = function () {
                document.getElementById("password1").onchange = validatePassword;
                document.getElementById("password2").onchange = validatePassword;
            }
            function validatePassword() {
                var pass2 = document.getElementById("password2").value;
                var pass1 = document.getElementById("password1").value;
                if (pass1 != pass2)
                    document.getElementById("password2").setCustomValidity("Passwords Don't Match");
                else
                    document.getElementById("password2").setCustomValidity('');
                //empty string means no validation error
            }
        </script>
        <!-- stats -->
        <script src="{{ asset('js/clientsignup/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('js/clientsignup/jquery.countup.js') }}"></script>
        <script>
$('.counter').countUp();
        </script>
        <!-- //stats -->
        <!-- pop-up-box -->
        <script src="{{ asset('js/clientsignup/jquery.magnific-popup.js') }} " type="text/javascript"></script>
        <script>
    $(document).ready(function () {
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
    });
        </script>
    </body>
</html>
