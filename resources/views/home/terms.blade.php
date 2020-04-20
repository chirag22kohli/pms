@extends('layouts.home')

@section('content')
<style>
    .container-page h3,  .container-page label{
        color:#fff;
    }
    .form-control{
        border: 1px solid #bbb ;
    }
</style>



<section id="cta" class="section cta text-center pb-0" style = "background-color:#fff">
    <div class="container">
        <div class="row clearfix">

            <!-- .col-md-6 end -->
        </div>
        <!-- .row end -->
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 wow fadeInUp" style = "text-align:left  ;color:black"> <h3 class="dark-grey">Terms and Conditions</h3>

                    <div class="col-md-12">

                        <?= $terms->meta_description?>


                    </div>




               
                <div class="col-md-12">
                    <p class="create-account-callout ">
                        Already a Memeber?
                        <a data-ga-click="Sign in, switch to sign up" href="{{ url('login') }}">Login</a>.
                    </p>
                </div>

            </div>
            <!-- .col-md-12 end -->
            <div class="col-xs-6 col-sm-6 col-md-6 wow fadeInUp" data-wow-duration="1s">
                <img src="{{ asset('home/images/mockup/iphone-2.png') }} " alt="mockup"/>
                <!-- .col-md-12 end -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="heading heading-1 mb-50 text--center wow fadeInUp" data-wow-duration="1s">  </br>
                        <h2 class="heading--title">Download & Install Chap now</h2>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-100 wow fadeInUp" data-wow-duration="1s">
                    <a class="btn-hover" href="#"><img src="{{ asset('home/images/appstore.png') }} " alt="download appstore"></a>
                    <a class="btn-hover" href="#"><img src="{{ asset('home/images/playstore.png') }} " alt="download playstore"></a>
                </div>
            </div>
        </div>
        <!-- .row end -->
    </div>
    <!-- .container end -->
    
    <style>
        
        .b-agent-demo_header-wrapper{
            background-color: #88cc88 !important; 
        }
    </style>
    <iframe
    allow="microphone;"
    width="350"
    height="430"
    src="https://console.dialogflow.com/api-client/demo/embedded/d9c7caec-089b-485b-ae84-ec342dbbc34e">
</iframe>

</section>


@endsection
