<!DOCTYPE html>
<html>
<head>
	<title>payment</title>
	<link rel="stylesheet" type="text/css" href="/Laravelapps/stripePay/public/css/bootstrap.css">
	<script src="https://js.stripe.com/v3/"></script>
</head>
<body>
	<h2>make payment</h2>

	<div class="container"> 
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form action="/Laravelapps/stripePay/public/payment" method="post" id="payment-form">
					{{ csrf_field() }}
				  <div>
				  	<label for="amount">
				      Total amount (USD)
				    </label>
				    <div>
				    <label>
				    	<input type="number" name="amount" id="amount" min="50">
					 cents</label>
					</div>

				    <label for="card-element">
				      Credit or debit card
				    </label>
				    <div id="card-element">
				      <!-- A Stripe Element will be inserted here. -->
				    </div>

				    <!-- Used to display Element errors. -->
				    <div id="card-errors" role="alert"></div>
				  </div>

				  <button>Submit Payment</button>
				</form>
			</div>
		</div>

	</div>

	<script>
		var stripe = Stripe('pk_test_S2pspncynZrv03977vaPZYbV');
		var elements = stripe.elements();

		var style = {
		  base: {
		    // Add your base input styles here. For example:
		    fontSize: '16px',
		    color: "#32325d",
		  }
		};

		// Create an instance of the card Element.
		var card = elements.create('card', {style: style});

		// Add an instnce of the card Element into the `card-element` <div>.
		card.mount('#card-element');

		card.addEventListener('change', function(event) {
		  var displayError = document.getElementById('card-errors');
		  if (event.error) {
		    displayError.textContent = event.error.message;
		  } else {
		    displayError.textContent = '';
		  }
		});


		// Create a token or display an error when the form is submitted.
		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
		  event.preventDefault();

		  stripe.createToken(card).then(function(result) {
		    if (result.error) {
		      // Inform the customer that there was an error.
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

</body>
</html>