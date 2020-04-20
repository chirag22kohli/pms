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
                                <div class="card-body">
                                    @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Please enter your email address or phone number to search for your account.') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Send Reset Link') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
