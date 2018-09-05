@extends('layouts.client')

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
        width:50%;
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
   
</style>
<!-- main-heading -->
<h2 class="main-title-w3layouts mb-2 text-center">Add New Payment Method</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">

    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <p>
            Note: We will deduct $1 from your card for the verification. Adding new payment method will remove the previous one.
        </p>
        <script src="https://js.stripe.com/v3/"></script>

            <form action="addPaymentMethod" method="post" id="payment-form">
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

                <button style = "margin-top: 20px;" class="btn btn-success">Pay $1</button>
            </form>
        <p class="paragraph-agileits-w3layouts">
            
        </p>
    </div>
    <!--// Error Page Info -->

</div>
<script>

// Create a Stripe client.
var stripe = Stripe('pk_test_TIGFLWMdosLpMXj1aPMypRr6');

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

    stripe.createToken(card).then(function (result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {


    console.log(token);

    $.ajax({
        url: "addPaymentMethod",
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {stripe: token, plan: '1'}
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
        success: function (data) {
            if (data == 'success') {
                $.alert({
                theme: 'supervan',
                title: 'Success',
                content: 'Method Added Successfully',
            });
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
