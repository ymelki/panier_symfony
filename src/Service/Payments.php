<?php
 
namespace App\Service;

use App\Service\Cart;
 
class Payments {
    private $cart;

    public function __construct(Cart $cart)
    { 
        $this->cart=$cart; 
    }

     public function create(){
        $total=$this->cart->getTotal();
        // This is your test secret API key.
        \Stripe\Stripe::setApiKey('sk_test_51KqHUhHxTuewjfx8W4mdPLu0MLeDPM0uBpINTS0lv1lxUEkSOfK7UXbvOK8WtTFUNau0cB4hKVk4FPTMfmSSZZZh00vo9JBk6o');


        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total*100,
            'currency' => 'eur'
        ]);

      // dd($paymentIntent);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        return $paymentIntent;
     }
}