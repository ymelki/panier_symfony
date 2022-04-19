<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Service\Cart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

     // voir le panier 
    /**
     * @Route("/cart/view", name="app_cart_view")
     */
    public function view(Request $request, SessionInterface $session, ProduitRepository $produitRepository, Cart $cart): Response
    {  

 
        $cart_full=$cart->getFull();
       
        $total=$cart->getTotal();
        
   
        //       dd($cart_full);
        return $this->render('cart/view.html.twig', [
            'controller_name' => 'CartController',
            'rows'=>$cart_full,
            'total'=>$total
        ]);

    }

    // vider le panier 
    /**
     * @Route("/cart/clear", name="app_cart_clear")
     */
    public function clear(Request $request, Cart $cart): Response
    { 
        // supprimer la variable cart contenant un tableau enregistré en session
        $cart->clear();

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);

    }


    /**
     * @Route("/cart/add/{id}", name="app_cart")
     */
    public function index($id, Request $request, SessionInterface  $session, Cart $cart): Response
    {  
        $cart->add($id);

 
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/cart/remove/{id}", name="app_remove")
     */
    public function remove($id,Cart $cart){
        // on utilise le service pour supprimer de notre panier
        $cart->remove($id);

        // on redirige
        return $this->redirectToRoute('app_cart_view'); 
    }
}
// faire en sorte que lorsque le panier est vide la vue fonctionne
// une problématique SQL
// on verra l'utilisation de STRIPE 
// Hebergement
// Mail