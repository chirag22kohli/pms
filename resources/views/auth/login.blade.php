@extends('layouts.home')

@section('content')
<style>
    .container-page h3,  .container-page label{
        color:#fff;
    }
</style>
<section id="slider" class="section slider slider-2">
    <div class="slide--item bg-overlay bg-overlay-theme_register">
        <div class="bg-section">
            <img src="{{ asset('home/images/background/bg-1.jpg') }}" alt="background">
        </div>
        <div class="container">

            <div class="row">
                <div class="container-fluid">
                    <section class="container">

                        <div class="container-page">			

                            <div class="col-md-6">

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group col-lg-12">
                                        <label>Email Address</label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Password</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

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

                            </div>

                            <div class="col-md-6">
                                <h3 class="dark-grey">Login to Experience Magic!</h3>
                                <p>
                                    By clicking on "Login" you agree to The Company's' Terms and Conditions
                                </p>
                                <p>
                                    While rare, prices are subject to change based on exchange rate fluctuations - 
                                    should such a fluctuation happen, we may request an additional payment. You have the option to request a full refund or to pay the new price. 
                                </p>
                                <p>
                                    Should there be an error in the description or pricing of a product, we will provide you with a full refund 
                                </p>
                                <p>
                                    Acceptance of an order by us is dependent on our suppliers ability to provide the product. 
                                </p>

                             
                            </div>

                        </div>
                    </section>
                </div>
            </div>
            <!-- .row end -->
        </div>
        <!-- .container end -->
    </div>
    <!-- .slide-item end -->
</section>
@endsection












