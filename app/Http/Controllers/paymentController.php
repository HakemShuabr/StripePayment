<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class paymentController extends Controller
{
    //
    public function pay(){
    	// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey("sk_test_mbzb7Scw0BFXbXOgtJJ5nMGU");

		// Token is created using Checkout or Elements!
		// Get the payment token ID submitted by the form:
		$token = $_POST['stripeToken'];
		$charge = \Stripe\Charge::create([
		    'amount' => $_POST['amount'],
		    'currency' => 'usd',
		    'description' => 'Example charge',
		    'source' => $token,
		]);

		session()->flash('message', 'successful payment');
		return redirect()->home();

    }
}
