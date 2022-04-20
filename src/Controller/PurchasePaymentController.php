<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Cart;
use App\Service\Payment;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController
{
    /**
     * @Route("/purchase/payment", name="app_purchase_payment")
     */
    public function index(Payment $payment, Cart $cart): Response
    {
        $total=$cart->getTotal();
        $intent=$payment->create();
  
 
        return $this->render('purchase_payment/index.html.twig', [
            'clientSecret' => $intent->client_secret,
            'total'=>$total
        ]);
    }


    /**
     * @Route("/purchase/payment/success", name="app_purchase_payment_success")
     */
    public function success(): Response
    {
     

      //  dd($intent);
      //   dd($intent->client_secret);

        // This is your test secret API key.
    \Stripe\Stripe::setApiKey('sk_test_51KqHUhHxTuewjfx8W4mdPLu0MLeDPM0uBpINTS0lv1lxUEkSOfK7UXbvOK8WtTFUNau0cB4hKVk4FPTMfmSSZZZh00vo9JBk6o');

    // Create a PaymentIntent with amount and currency
    $intent=\Stripe\PaymentIntent::create([
        'amount' => 2000,
        'currency' => 'eur',

    ]); 
        return $this->render('purchase_payment/success.html.twig', [
           
        ]);
 
 
    }
}
