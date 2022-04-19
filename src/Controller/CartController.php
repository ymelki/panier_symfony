<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
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
    public function view(Request $request, SessionInterface $session, ProduitRepository $produitRepository): Response
    {  

       // Recuperation du panier
       // Si il existe on aura le tableau rempli sinon un tableau vide
        $cart=$session->get('cart' , []);
       
        // boucle sur le tableau : identifiant_produit => quantité
        // Recuperer les données du produits
        foreach ($cart as $key=>$value){
            $cart_full[]=[
                'product'=>   $produitRepository->find($key) ,
                'quantite'=>$value
                
            ];

            // Calcul du TOTAL uniquement
           $total=0;
           foreach ($cart_full as $couple){
               $total=$total + ($couple['product']->getPrix()*$couple['quantite']);
           }
          

        }
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
    public function clear(Request $request, SessionInterface $session): Response
    { 
        // supprimer la variable cart contenant un tableau enregistré en session
        $session->remove('cart');

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);

    }


    /**
     * @Route("/cart/add/{id}", name="app_cart")
     */
    public function index($id, Request $request, SessionInterface  $session): Response
    { 
        //Cas N1 : Le panier n'existe pas , la session n'existe pas : je créé la session
        //Cas N2 : Le panier existe , la session existe : je modifie la session
        $cart =  $session->get('cart' , []);


        // Cas N3 : Le panier existe , je rajouter un produit deja existant quantite ++.
        // si le tableau contient la clé identifiant correspondant au produit
        // alors je rajoute une quantité ++
        // si non je suis dans le cas classique
        if (array_key_exists( $id, $cart) ) {
            $cart[$id] = $cart[$id] + 1 ;
        }
        else {
        // Ajouter dans le tableau  [] l'identifiant et la quantité = 1
        // $cart[ identifiant du produit  ] = Quantité 1 par défaut
        $cart[$id] = 1;
        }
  
        // on ecrit dans la session nommé 'cart' la variable $cart contenant []
        // on genere un fichier sur le serveur
        $session->set('cart',$cart);


        // affiche la session
        dd($cart);
        //die arrete l execution--------------------------------

        // Vardump et Die 
        dd($id);
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
