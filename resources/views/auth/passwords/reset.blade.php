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
                            <h5 style = "text-align:center;color:#fff;">Please enter your Email and set new password for your account!</h5>
                            </br></br>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf


                                <div class="col-md-8 col-sm-offset-2">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('password.request') }}">
                                            @csrf

                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <div class="form-group row">
                                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                                    @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                    @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Reset Password') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
