@extends('layouts.clientSignup')

@section('content')


<div class="main">
    <h1>Chap Pricing Plans</h1>
    <div class="w3layouts_main_grids">

        @foreach($plans as $plan)
        <div class="w3_agile_main_grid w3_agileits_pricing_grid">
            <div class="wthree_learning_grid1">
                <div class="w3ls_pricing_grid_top">
                    <h3>$ <span class="counter agile_counter"> {{ $plan->price }}</span></h3>
                    <p>{{ ucfirst($plan->price_type) }}</p>
                    <div class="w3ls_pricing_grid_top_pos">
                        <h4>{{ ucfirst($plan->name) }}</h4>
                    </div>
                </div>
                <div class="w3l_pricing_grid_content">
                    <ul class="w3_count">

                        <?php if ($plan->type == 'size') { ?>
                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i> {{ $plan->max_trackers }} MB Storage</li> 
                            
                        <?php } else { ?>

                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>{{ $plan->max_trackers }} Trackers</li> 

                            <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>Unlimited Storage</li> 

                        <?php } ?>


                        <li><i class="fa fa-check" aria-hidden="true"></i>True AR Experience</li>

                    </ul>
                </div>
                <div class="w3_agile_learning_grid1_pos">
                    <a href="#small-dialog" onclick="planSelection({{ $plan->id }})"  class="w3_agileits_sign_up popup-with-zoom-anim">Sign Up</a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="clear"> </div>
    </div>
    <div class="agileits_copyright">
        <p>© 2018 CHAP Augumented Reality. All rights reserved </p>
    </div>
</div>
<div class="wthree_pop_up"> 
    <div id="small-dialog" class="mfp-hide agile_signup_form">
        <h2>Sign Up Form</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-control"> 
                <label class="header">Name <span>:</span></label>
                <input type="text" id="firstname" class="{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="First Name" title="Please enter your First Name" required="">
            </div>



            <div class="form-control">	
                <label class="header">Email Address <span>:</span></label>
                <input type="email" id="email" placeholder="mail@example.com" title="Please enter a valid email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required required="">
                @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <input type="hidden" id = "planId" name = "planId">
            <div class="form-control">	
                <label class="header">Password <span>:</span></label>
                <input id="password1" type="password" placeholder="password" class="lock {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            </div>

            <div class="form-control">	
                <label class="header">Confirm Password <span>:</span></label>	
                <input id="password2" type="password"  class="lock" placeholder="confirmpassword" name="password_confirmation" required>

            </div>	

            <div class="w3_submit">
                <button type="submit" class="register">
                    {{ __('Register') }}
                </button>
            </div>


        </form>
        <div >
            <a href = "login">Already Have a Account?</a>
        </div>
    </div>
</div>
<script>
    function planSelection(id){
    $('#planId').val(id);
    }
</script>
@endsection
