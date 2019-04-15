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
            <div class="col-xs-6 col-sm-6 col-md-6 wow fadeInUp" style = "text-align:left  ;color:black"> <h3 class="dark-grey">Registration</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="col-md-12">




                        <div class="form-group col-lg-12">
                            <label>Name</label>
                            <input type="text" id="firstname" class="{{ $errors->has('name') ? ' is-invalid' : '' }} form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="First Name" title="Please enter your First Name" required="">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Email Address</label>
                            <input type="email" id="email" placeholder="mail@example.com" title="Please enter a valid email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required required="">
                            @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Phone</label>
                            <input type="number" id="phone" placeholder="(123) 456-789" title="Please enter a phone" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required required="">
                            @if ($errors->has('phone'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>
                        <input type="hidden" value="{{$plan_id}}" id = "planId" name = "planId">
                        <div class="form-group col-lg-6">
                            <label>Password</label>
                            <input id="password1" type="password" placeholder="password" class="form-control lock {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Repeat Password</label>
                            <input id="password2" type="password"  class="form-control lock" placeholder="confirm password" name="password_confirmation" required>

                        </div>






                        <div class="form-group col-lg-12">
                            <input type="checkbox"  class="checkbox "  style = "float:left" required/> 
                            <a href = "<?= url('terms')?>" style = "float:left;margin-left:10px" >Agree Terms and Conditions</a>
                        </div>
                        </br>
                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary"> {{ __('Register') }}</button>
                        </div>
                    </div>




                </form> 

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
</section>


@endsection
