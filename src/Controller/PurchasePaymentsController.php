<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Cart;
use App\Service\Payments;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentsController extends AbstractController
{
 

    /**
     * @Route("/purchase/payments/success", name="app_purchase_payments_success")
     */
    public function success(): Response
    {
 
        //1 Vider le Panier $cart->remove
        //2 MAJ les données dans la BD Table : ligne_commande Repository
        //3 MAJ les données dans la BD Table : Mescommandes Repository
  
        return $this->render('purchase_payments/success.html.twig');

    }

    /**
     * @Route("/purchase/payments", name="app_purchase_payments")
     */
    public function index(Payments $payments,Cart $cart): Response
    {
        $paymentIntent=$payments->create();
        $total=$this->cart->getTotal();

        return $this->render('purchase_payments/index.html.twig', [
            'controller_name' => 'PurchasePaymentsController',
            'clientSecret'=>$paymentIntent->client_secret,
            'total'=>$total
        ]);
    }
}
