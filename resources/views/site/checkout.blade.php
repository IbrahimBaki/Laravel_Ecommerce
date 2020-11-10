@extends('layouts.store')
@section('title','checkout')
@section('style')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
/*
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;

 */
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

    </style>

@endsection
@section('content')
<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url({{asset('assets/store/images/heading-pages-06.jpg')}});">
    <h2 class="l-text2 t-center">
        Contact
    </h2>
</section>

<!-- content page -->
<section class="bgwhite p-t-66 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-b-30">
                <div class="p-r-20 p-r-0-lg">
                    <div class="contact-map size21" id="google_map" data-map-x="40.614439" data-map-y="-73.926781" data-pin="{{asset('assets/store/images/icons/icon-position-map.png')}}" data-scrollwhell="0" data-draggable="1"></div>
                </div>
            </div>

            <div class="col-md-6 p-b-30">
                <form class="payment-form" action="#">
                    <h3 class="m-text26 p-b-36 p-t-15">Checkout</h3>

                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="name" id="name" placeholder="Full Name" >
                    </div>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="email" name="email" id="email" placeholder="Email Address">
                    </div>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="number" id="number" placeholder="Phone Number">
                    </div>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="address" id="address" placeholder="Address">
                    </div>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="city" id="city" placeholder="Your City">
                    </div>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="province" id="province" placeholder="Province">
                    </div>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="postal_code" id="postal_code" placeholder="Postal Code">
                    </div>

                    <h4 class="m-text26 p-b-36 p-t-15">Payment Details</h4>
                    <div class="bo4 of-hidden size15 m-b-20">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="card_name" placeholder="Name On Card" id="card_name">
                    </div>
                    <label for="card-element">
                        Credit or debit card
                    </label>
                    <div class="bo4 of-hidden size15 m-b-20">
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                    </div>
                            <div id="card-errors" role="alert"></div>

                    <div class="sizefull m-t-8">
                        <!-- Button -->
                        <button type="" class="flex-c-m sizefull bg1 bo-rad-23 hov1 m-text3 trans-0-4 p-4">
                            Complete Order
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
@stop




@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
    <script src="{{asset('assets/store/js/map-custom.js')}}"></script>
    <script>
        // Create a Stripe client.
        var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');

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
        var card = elements.create('card', {
            style: style,
            hidePostalCode: true,

        });

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
           // form.submit();
        }
    </script>
@stop
