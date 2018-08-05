@extends('layouts.clientSignup')

@section('content')


<div class="main">
    <h1>Complete Registration</h1>
    <div class="w3layouts_main_grids">
        <div class="w3_agile_main_grid w3_agileits_pricing_grid" style ="margin-left:34%">
            <div class="agileits_learning_grid1" >
                <div class="w3ls_pricing_grid_top">
                    <h3>$ <span class="counter agile_counter"> {{ $plan->price }}</span></h3>
                    <p>{{ ucfirst($plan->price_type) }}</p>
                    <div class="w3ls_pricing_grid_top_pos">
                        <h4>{{ ucfirst($plan->name) }}</h4>
                    </div>
                </div>
                <div class="w3l_pricing_grid_content">
                    <ul class="w3_count">
                        <li><i class="fa fa-check" aria-hidden="true"></i>{{ $plan->max_trackers }} Trackers</li>
                        <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>{{ $plan->max_projects }} Projects</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i>True AR Experience</li>
                        <li><i class="fa fa-check w3layouts_icon" aria-hidden="true"></i>3GB BandWidth</li>
                    </ul>
                </div>
                <div class="w3_agile_learning_grid1_pos">
                    <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="makePayment">
                        {{ csrf_field() }}



                        <input class="w3-input w3-border" value = "{{ $plan->price }}" name="amount" type="hidden"></p>      
                        <button class="paypalButton">Pay ${{ $plan->price }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="clear"> </div>
    <div class="agileits_copyright">
        <p>© 2018 CHAP Augumented Reality. All rights reserved </p>
    </div>
</div>

<script>
    paypal.Button.render({
        env: 'sandbox',
        client: {
            sandbox: 'demo_sandbox_client_id'
        },
        style: {
            color: 'gold', // 'gold, 'blue', 'silver', 'black'
            size: 'medium', // 'medium', 'small', 'large', 'responsive'
            shape: 'rect'    // 'rect', 'pill'
        },
        payment: function (data, actions) {
            return actions.payment.create({
                transactions: [{
                        amount: {
                            total: '0.01',
                            currency: 'USD'
                        }
                    }]
            });
        },
        onAuthorize: function (data, actions) {
            return actions.payment.execute()
                    .then(function () {
                        window.alert('Thank you for your purchase!');
                    });
        }
    }, '#paypal-button');
</script>
@endsection
