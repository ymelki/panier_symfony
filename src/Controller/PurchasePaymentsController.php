<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Cart;
use App\Entity\Facture;
use App\Service\Payments;
use App\Entity\Mescommandes;
use App\Repository\FactureRepository;
use App\Repository\ProduitRepository;
use App\Repository\MescommandesRepository;
use DateTime;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentsController extends AbstractController
{
 

    /**
     * @Route("/purchase/payments/success", name="app_purchase_payments_success")
     */
    public function success(Security $security, FactureRepository $factureRepository, MescommandesRepository $mescommandesRepository, Cart $cart,SessionInterface $session, ProduitRepository $produitRepository): Response
    {
 

        //1 MAJ les données dans la BD Table : ligne_commande Repository

        // recuperation du panier [ id => Quantite : 3 => 5]
        $cart_s=$session->get('cart' , []);


        // dd($cart_s);

        // Je vais lire mon panier 
        // a chaque identifiant je vais le stocke dans une nouvelle ligne
        // de ma table mescommande

        // recuperation de l'objet user en session
        $user=$security->getUser();
        $mescommande = new Mescommandes();
        $facture=new Facture();
        // je modifie l'objet facture en mettant le user à l'interieur
        $facture->setUser($user);
        $facture->setDatecreation(new DateTime());
        $factureRepository->add($facture);


        foreach ($cart_s as $id=>$quantite){
            // mescommandes correspond à ligne commande
            $mescommande = new Mescommandes();
            
            // stock dans $p le produit correpond à $id issue du panier grace au Repository
            $p=$produitRepository->find($id);
            // modifier l'entité et on utiliser setProduits pour inserer le produit dans l'entité commande
            $mescommande->setProduits($p);
            // modifier l'entité et on utiliser setQuantite pour inserer la quantité dans l'entité commande
            $mescommande->setQuantite($quantite);
            $mescommande->setTotal($p->getPrix()*$quantite);

            $mescommande->setFacture($facture);

 
            // Ajout en BD de la la nouvelle ligne issue du panier
            // grâce à entity manager
            $mescommandesRepository->add($mescommande);
        } 

        //2 MAJ les données dans la BD Table : Mescommandes Repository Commande global
        // Recuperer un repository qui va ajouter le lien avec la commande
        // Recuperer un repository qui va ajouter le lien avec le user





        //3 Vider le Panier $cart->remove
        $cart->clear();

  
        return $this->render('purchase_payments/success.html.twig');

    }

    /**
     * @Route("/purchase/payments", name="app_purchase_payments")
     */
    public function index(Payments $payments,Cart $cart): Response
    {
        $paymentIntent=$payments->create();
        $total=$cart->getTotal();

        return $this->render('purchase_payments/index.html.twig', [
            'controller_name' => 'PurchasePaymentsController',
            'clientSecret'=>$paymentIntent->client_secret,
            'total'=>$total
        ]);
    }
}
