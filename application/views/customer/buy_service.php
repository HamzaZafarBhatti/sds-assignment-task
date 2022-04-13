<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Dashboard</title>
    <style>
        .stripe-field {
            border: 1px solid #ccc;
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <?php
    $this->load->config('stripe');
    $this->load->view('customer/navbar');
    ?>
    <section>
        <div class="card">
            <div class="card-body">
                <?php $this->load->view('alert'); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="d-inline">Buy Service</h4>
                            </div>
                            <form method="post" action="<?php echo site_url('checkout') ?>" id="datas_form">
                                <input type="hidden" name="service_id" value="<?php echo $service->id ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Service Name</label>
                                        <p class="fw-bold"><?php echo $service->name ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Service Description</label>
                                        <p class="fw-bold"><?php echo $service->description ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Service Provider</label>
                                        <p class="fw-bold"><?php echo $service->provider_name ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Service Price</label>
                                        <p class="fw-bold">$<?php echo $service->price ?></p>
                                    </div>
                                    <div class="checkout-widget checkout-contact">
                                        <h5 class="title">Share your Card details </h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="cardNumber" class="stripe-field"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div id="cardExpiry" class="stripe-field"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <div id="cardCvc" class="stripe-field"></div>
                                            </div>
                                        </div>
                                        <div class="text-danger mt-1" id="cardNumber-errors"></div>
                                        <div class="text-danger mt-1" id="cardExpiry-errors"></div>
                                        <div class="text-danger mt-1" id="cardCvc-errors"></div>
                                        <div class="form-group">
                                            <div id="card-element"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary text-end">Checkout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var pub_key = '<?php echo $this->config->item('stripe_pub_key'); ?>';
        var stripe = Stripe(pub_key);
        var elements = stripe.elements();
        // var cardElement = elements.create('card', {
        //     'hidePostalCode': true
        // });
        var cardNumberElement = elements.create('cardNumber');
        var cardExpiryElement = elements.create('cardExpiry');
        var cardCvcElement = elements.create('cardCvc');
        // var resultContainer = document.getElementById('paymentResponse');
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '24px',
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
        // cardElement.mount('#card-element', {style: style});
        cardNumberElement.mount('#cardNumber');
        cardExpiryElement.mount('#cardExpiry');
        cardCvcElement.mount('#cardCvc');
        // cardElement.on('change', function(event) {
        //     if (event.complete) {
        //         // enable payment button
        //     } else if (event.error) {
        //         // show validation to customer
        //     }
        // });
        cardNumberElement.on('change', function(event) {
            var displayError = document.getElementById('cardNumber-errors');
            if (event.complete) {
                displayError.textContent = '';
            } else if (event.error) {
                displayError.textContent = event.error.message;
            }
        });
        cardCvcElement.on('change', function(event) {
            var displayError = document.getElementById('cardCvc-errors');
            if (event.complete) {
                displayError.textContent = '';
            } else if (event.error) {
                displayError.textContent = event.error.message;
            }
        });
        cardExpiryElement.on('change', function(event) {
            var displayError = document.getElementById('cardExpiry-errors');
            if (event.complete) {
                displayError.textContent = '';
            } else if (event.error) {
                displayError.textContent = event.error.message;
            }
        });
        var form = document.getElementById('datas_form');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            createToken();
        });

        // Create single-use token to charge the user
        function createToken() {
            stripe.createToken(cardNumberElement, cardExpiryElement, cardCvcElement).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    swal({
                        icon: 'error',
                        title: result.error.message,
                    });
                    // alert(result.error.message);
                    // resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }

        // Callback to handle the response from stripe
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripe-token');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // setTimeout(function(){
            // alert(token.id);

            // Submit the form
            form.submit();
            // }, 1000);
        }
    </script>
</body>

</html>