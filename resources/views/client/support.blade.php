@extends('layouts.client')

@section('content')

<!-- main-heading -->
<style>
    
    /**
* The CSS shown here will not be introduced in the Quickstart guide, but
* shows how you can use CSS to style your Element's container.
*/
input,
.StripeElement {
    width:50%;
  height: 40px;
  padding: 10px 12px;

  color: #32325d;
  background-color: white;
  border: 1px solid transparent;
  border-radius: 4px;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

input:focus,
.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
    
</style>
<script src="https://js.stripe.com/v3/"></script>

<form action="/charge" method="post" id="payment-form" style = "">
  <div class="form-row">
    <label for="card-element">
      Credit or debit card
    </label>
    <div id="card-element">
      <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>
  </div>

  <button>Submit Payment</button>
</form>


<script>


// Create a Stripe client.
var stripe = Stripe('pk_test_51Gyp0MGZKV3bPl7UeZA9dYB8sWgas73XSVp43ckq4x6HZnsI9fTpcEKEce7dtDlZvzrAYarO7M8sT1l2cigt6Bpf00U8iQdi4c');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
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
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
        console.log(result.token);
        return false;
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>

<h2 class="main-title-w3layouts mb-2 text-center">Help and Support</h2>
<!--// main-heading -->

<!-- Error Page Content -->
<div class="blank-page-content">
    <div class="flash-message">
        </br>
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    <!-- Error Page Info -->
    <div class="outer-w3-agile mt-3">
        <p class="paragraph-agileits-w3layouts">Please enter the following Support form to get 
            assistance from CHAP. We would love to help you out!
        </p>
    </div>
    <div class="outer-w3-agile col-xl mt-3">
        <h4 class="tittle-w3-agileits mb-4">Get Support</h4>
        <form action="createSupport" method="post">
            {!! Form::token() !!}
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" name ="email" value = "{{ Auth::user()->email }}" class="form-control" id="exampleFormControlInput1" placeholder="{{ Auth::user()->email }}" required="" readonly> 
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Reason</label>
                <select name ="reason"   class="form-control" id="exampleFormControlSelect1">
                    <option value = "ar">AR Experience</option>
                    <option value = "payment" >Payment</option>
                    <option value = "other">Other</option>

                </select>
            </div>

            <div class="form-group">
                <label for="issue">Please elaborate the Issue so we could assist you better.</label>
                <textarea  name ="description" class="form-control" id="exampleFormControlTextarea1" rows="3" required=""></textarea>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!--// Error Page Info -->

</div>
@endsection
