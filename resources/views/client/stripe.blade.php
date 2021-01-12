<!DOCTYPE html>
<html>
<head>
	<title>Payment Gateway</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style type="text/css">
        .container {
            
            margin-top: 40px;
        }

        h1{
            font-size:30px;
            font-weight:600;
            margin-top:20px;
            margin-bottom:50px!important;
        }
        h2{
            font-size:22px;
            font-weight:600;
            margin-top:20px;
            margin:auto;
            margin-bottom:30px;
        }
        .block-center{
            text-align:center;
        }
        .option{
            font-weight:500;
            margin: 10px 10px 10px 10px;
        } 
        input{
            margin:0px 10px 10px 10px;
        }
        #card_details{
            margin-left:5%;
        }
    </style>
</head>
<body>
    
<div class="container">  
    <h1 align="center">How would you like to pay?</h1>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <form action="{{ url('stripe-payment') }}" method="post" id="payment-form">
                @csrf
                <div class="option"> 
                    <input id="card" type="radio" checked name="payment-method">
                    <label for="card">Pay with Card</label>
                </div>
                <hr>
                <div id="card_details">
                @if (session()->has('error'))
                    <div class="text-danger font-italic">{{ session()->get('error') }}</div>
                @endif
                
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="name">Name</label>
                            @error('name')
                            <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="email">Email</label>
                            @error('email')
                            <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <!-- Display errors returned by createToken -->
                            <label>Card Number</label>
                            <div id="paymentResponse" class="text-danger font-italic"></div>
                            <div id="card_number" class="field form-control"></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>Expiry Date</label>
                            <div id="card_expiry" class="field form-control"></div>
                        </div>
                        <div class="col-md-3">
                            <label>CVC Code</label>
                            <div id="card_cvc" class="field form-control"></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="form-check form-check-inline custom-control custom-checkbox">
                                <input type="checkbox" name="terms_conditions" id="terms_conditions" class="custom-control-input">
                                <label for="terms_conditions" class="custom-control-label">
                                    I agree to terms & conditions
                                </label>
                            </div>
                            @error('terms_conditions')
                            <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 small text-muted">
                            <div class="alert alert-warning">
                                <strong>NOTE: </strong> All the payments are handled by <a target="_blank"
                                    href="https://stripe.com">STRIPE</a>. We don't store any of your data.
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="text-danger font-italic generic-errors"></div>
                        </div>
                    </div>               
                </div>
                <div class="option"> 
                    <input id="cash" type="radio" name="payment-method">
                    <label for="cash">Pay with Cash</label>
                </div>
                <div class="row form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="submit" value="Place Order" class="btn btn-primary pay-via-stripe-btn">
                    </div>
                </div>
            </form>
        </div>
            

        <div class="col-md-4 col-md-offset-1 block-center">
            <h2>Your Order</h2>
            <table class="table table-striped">
                <thead align="center">
                  <tr class="table-active" style="font-weight:600;font-size:20px">
                    <td>Item</td>
                    <td>Option</td>
                    <td>Quantity</td>
                    <td>Price</td>
                  </tr>
                </thead>
                <tbody id="itemTable" align="center">
                
                </tbody>
            </table>
        </div> 
    </div>
</div>
  
</body>
  
<script>
    $(document).ready(function(){

        @if (Session::has('success'))
            sessionStorage.setItem("total","0");
            sessionStorage.setItem("MyPurchase","[]");
        @endif

        $('#purchase_list').val(sessionStorage.getItem("MyPurchase"));
        $('#restaurantID').val(sessionStorage.getItem("restaurantID"));
        $('#userID').val(sessionStorage.getItem("userID"));
        $('#tot_price').val(sessionStorage.getItem("total"));

        myPur = JSON.parse(sessionStorage.getItem('MyPurchase'));
        myPur.forEach((item)=>{
            $('#itemTable').append(`<tr><td>${item.itemN}</td><td>${item.optionN}</td><td>${item.itemQ}</td><td>$${(item.itemP*item.itemQ).toFixed(2)}</td></tr>`);
        });
        $('#itemTable').append(`<tr><td><b>Total</b></td><td></td><td></td><td>$${sessionStorage.getItem("total")}</td></tr>`);


        const charge = sessionStorage.getItem("total");
        $("#payment-form").append(`<input type="hidden" name="chargeAmount" value=${charge} >`);

        $('#card').click(()=>{
            $('#card_details').show();
        });
        $('#cash').click(()=>{
            $('#card_details').hide();
        })


    })
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Create an instance of the Stripe object
    // Set your publishable API key
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');

    // Create an instance of elements
    var elements = stripe.elements();

    var style = {
        base: {
            fontWeight: 400,
            fontFamily: '"DM Sans", Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            lineHeight: '1.4',
            color: '#1b1642',
            padding: '.75rem 1.25rem',
            '::placeholder': {
                color: '#ccc',
            },
        },
        invalid: {
            color: '#dc3545',
        }
    };

    var cardElement = elements.create('cardNumber', {
        style: style
    });
    cardElement.mount('#card_number');

    var exp = elements.create('cardExpiry', {
        'style': style
    });
    exp.mount('#card_expiry');

    var cvc = elements.create('cardCvc', {
        'style': style
    });
    cvc.mount('#card_cvc');

    // Validate input of the card elements
    var resultContainer = document.getElementById('paymentResponse');
    cardElement.addEventListener('change', function (event) {
        if (event.error) {
            resultContainer.innerHTML = '<p>' + event.error.message + '</p>';
        } else {
            resultContainer.innerHTML = '';
        }
    });

    // Get payment form element
    var form = document.getElementById('payment-form');

    // Create a token when the form is submitted.
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        createToken();
    });

    // Create single-use token to charge the user
    function createToken() {
        stripe.createToken(cardElement).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error
                resultContainer.innerHTML = '<p>' + result.error.message + '</p>';
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
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

    $('.pay-via-stripe-btn').on('click', function () {
        var payButton   = $(this);
        var name        = $('#name').val();
        var email       = $('#email').val();

        if (name == '' || name == 'undefined') {
            $('.generic-errors').html('Name field required.');
            return false;
        }
        if (email == '' || email == 'undefined') {
            $('.generic-errors').html('Email field required.');
            return false;
        }

        if(!$('#terms_conditions').prop('checked')){
            $('.generic-errors').html('The terms conditions must be accepted.');
            return false;
        }
    });

</script>

</html>