@extends('layouts.home')

@section('content')
<style>
    .container-page h3,  .container-page label{
        color:#fff;
    }
</style>

<section id="cta" class="section cta text-center pb-0" style = "background-color:#fff">
    <div class="container">
        <div class="row clearfix">

            <!-- .col-md-6 end -->
        </div>
        <!-- .row end -->
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 wow fadeInUp" style = "text-align:left  ;color:black"> <h3 class="dark-grey">Login to Experience Magic!</h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label>Email Address</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" style="border: 1px solid #bbb " required autofocus>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" style="border: 1px solid #bbb " required>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>



                    <div class = "form-group col-lg-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                </form>
                <p class="create-account-callout mt-3">
                    New to Chap?
                    <a data-ga-click="Sign in, switch to sign up" href="{{ url('/viewPlans') }}">Create an account</a>.
                </p>
            </div>
            <!-- .col-md-12 end -->
            <div class="col-xs-6 col-sm-6 col-md-6 wow fadeInUp" data-wow-duration="1s">
                <img src="{{ asset('home/images/mockup/2-layers.png') }} " alt="mockup"/>
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












