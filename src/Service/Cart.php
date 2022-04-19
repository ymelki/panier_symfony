<?php
 
namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart {

    protected $session;
    protected $produitRepository;

    public function __construct(SessionInterface $session,ProduitRepository $produitRepository)
    {
        $this->session=$session;
        $this->produitRepository=$produitRepository;
    }

    public function add(int $id){
          //Cas N1 : Le panier n'existe pas , la session n'existe pas : je créé la session
        //Cas N2 : Le panier existe , la session existe : je modifie la session
        $cart =  $this->session->get('cart' , []);


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
        $this->session->set('cart',$cart);
 




    }

    public function clear(){
        // supprimer la variable cart contenant un tableau enregistré en session
        $this->session->remove('cart');
    }

    public function getFull():array{
               // Recuperation du panier
       // Si il existe on aura le tableau rempli sinon un tableau vide
       $cart=$this->session->get('cart' , []);
       // EX :  $cart[5]=3    $cart[34]=2    $cart[7]=7
       /* [  
          Identifiant produit : 5 , Quantité : 3
          Identifiant produit : 34 , Quantité : 2
          Identifiant produit : 7 , Quantité : 7
         ]
        */
        // boucle sur le tableau : identifiant_produit => quantité
        // Recuperer les données du produits
        foreach ($cart as $id=>$quantite){
            //  $cart[5]=3    $cart[34]=2    $cart[7]=7
           /* 
           $cart_full[O][produit]=[id=5,nom=chaise,prix=300]
           $cart_full[O][quantite]=3
            $cart_full[1][produit]= 
            $cart_full[1][quantite]=
             ...
            */
            $cart_full[]=[
                'product'=> $this->produitRepository->find($id) ,
                'quantite'=>$quantite
            ];
                        
            // Calcul du TOTAL uniquement
          //  var_dump($cart_full);
            
          

        }
        return $cart_full;
    }

    public function getTotal(){

        $cart_full=$this->getFull();
        $total=0;
        foreach ($cart_full as $couple){
            var_dump($couple);
            echo "<br />";
            $total=$total + ($couple['product']->getPrix()*$couple['quantite']);
        }

        return $total;

    }
    
    public function remove(){
        
    }


    



}


?>