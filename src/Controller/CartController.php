<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{


    // vider le panier 
    /**
     * @Route("/cart/clear", name="app_cart_clear")
     */
    public function clear(Request $request): Response
    { 
        // supprimer la variable cart contenant un tableau enregistré en session
        $request->getSession()->remove('cart');

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);

    }


    /**
     * @Route("/cart/add/{id}", name="app_cart")
     */
    public function index($id, Request $request): Response
    { 
        //Cas N1 : Le panier n'existe pas , la session n'existe pas : je créé la session
        //Cas N2 : Le panier existe , la session existe : je modifie la session
        $cart =  $request->getSession()->get('cart' , []);

        // Ajouter dans le tableau  [] l'identifiant et la quantité = 1
        // $cart[ identifiant du produit  ] = Quantité 1 par défaut
        $cart[$id] = 1;

        // on ecrit dans la session nommé 'cart' la variable $cart contenant []
        $request->getSession()->set('cart',$cart);

        // affiche la session
        dd($cart);

        // Vardump et Die 
        dd($id);
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
