@extends('layouts.clientSignup')

@section('content')

<style>
    .StripeElement {
        background-color: white;

        padding: 10px 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    #card-errors{
        font-size: 15px;
        color: #f81e1e;
        padding: 7px;
    }
    #payment-form{
        margin-top: 15px;
    }
    .jconfirm-holder{
        padding-top: 40px;
        padding-bottom: 40px;
        width: 26%;
        margin: 0px auto;
    }
</style>
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


                    <!-- <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="makePayment">
                         {{ csrf_field() }}
 
 
 
                         <input class="w3-input w3-border" value = "{{ $plan->price }}" name="amount" type="hidden"></p>      
                         <button class="paypalButton">Pay ${{ $plan->price }}</button>
                     </form> -->

                </div>


            </div>
            <script src="https://js.stripe.com/v3/"></script>

            <form action="makePayment" method="post" id="payment-form">
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div class="form-row">
                    <label for="card-element">

                    </label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>

                <button class="paypalButton">Pay ${{ $plan->price }}</button>
            </form>
        </div>
    </div>

    <div class="clear"> </div>
    <div class="agileits_copyright">
        <p>© <?= date('Y') ?> CHAP Augumented Reality. All rights reserved </p>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script>

var key = '{{ env('STRIPE_KEY') }}';
// Create a Stripe client.
var stripe = Stripe(key);

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
    event.preventDefault();
 $(".paypalButton").attr("disabled", true);
    stripe.createToken(card).then(function (result) {
        if (result.error) {
            //  $(".paypalButton").attr("disabled", true);
            // Inform the user if there was an error.
             $(".paypalButton").attr("disabled", false);
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
           // $(".paypalButton").attr("disabled", true);
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {


   // console.log(token);
   // return false;
    //$(".paypalButton").attr("disabled", true);
    $.ajax({
        url: "makePayment",
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {stripe: token, plan: '<?= $plan->price ?>'}
        ,
        cache: false,
        beforeSend: function (xhr) {
            //Add your image loader here
            $.alert({
                theme: 'supervan',
                title: 'Processing Payment',
                content: 'Please wait while we process your payment and set up your AR Experience.',
            });
        },
        error: function (xhr) {
            //Add your image loader here
            $.alert({
                theme: 'supervan',
                title: 'Oops!',
                content: 'There is some error in processing your payment. Please contact administrator.',
            });
        },
        success: function (data) {
            console.log(data);
            if (data == 'success') {
                location.reload();
            } else {
                $.alert({
                    theme: 'supervan',
                    title: 'Payment Failed',
                    content: 'There is some issue in processing your payment, Please try again.',
                });
            }
        }
    }
    );

}
//
//paypal.Button.render({
//    env: 'sandbox',
//    client: {
//        sandbox: 'demo_sandbox_client_id'
//    },
//    style: {
//        color: 'gold', // 'gold, 'blue', 'silver', 'black'
//        size: 'medium', // 'medium', 'small', 'large', 'responsive'
//        shape: 'rect'    // 'rect', 'pill'
//    },
//    payment: function (data, actions) {
//        return actions.payment.create({
//            transactions: [{
//                    amount: {
//                        total: '0.01',
//                        currency: 'USD'
//                    }
//                }]
//        });
//    },
//    onAuthorize: function (data, actions) {
//        return actions.payment.execute()
//                .then(function () {
//                    window.alert('Thank you for your purchase!');
//                });
//    }
//}, '#paypal-button');
</script>
@endsection
