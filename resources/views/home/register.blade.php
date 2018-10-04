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
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="col-md-6">
                                    <h3 class="dark-grey">Registration</h3>




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






                                    <div class="col-sm-12">
                                        <input type="checkbox" class="checkbox"  style = "float:left" required/> 
                                        <a href = "#" style = "float:left;margin-left:10px" >Agree Terms and Conditions</a>
                                    </div>



                                </div>

                                <div class="col-md-6">
                                    <h3 class="dark-grey">Terms and Conditions</h3>
                                    <p>
                                        By clicking on "Register" you agree to The Company's' Terms and Conditions
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

                                    <button type="submit" class="btn btn-primary"> {{ __('Register') }}</button>
                                </div>
                            </form> 
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
