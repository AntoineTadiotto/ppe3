<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Marque;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\InfoUser;
use App\Form\InfoUserType;
use App\Form\LivraisonType;
use App\Entity\ModePaiement;
use App\Entity\ModeLivraison;
use App\Entity\LivraisonOrder;
use App\Entity\LigneCart;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(UserInterface $user, Request $request, ObjectManager $manager)
    {
        $thisCart = $user->getCart();


        // $thisArticle = $thisCart->getArticles();
    
        $lignes = $thisCart->getLigneCarts();

        $repo = $this->getDoctrine()->getRepository(Category::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        
        $marques = $repoM->findAll();
        $categories = $repo->findAll();


        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            // 'thisArticle' => $thisArticle,
            'categories' => $categories,
            'marques' => $marques,
            'lignes' => $lignes
        ]);
    }
    /**
     * @Route("/panier/ajouter/{id}", name="ajouter_panier")
     * 
     */
    public function ajouter(Article $article, Request $request, UserInterface $user, ObjectManager $manager)
    {
    
        //IF AJAX ADD PANIER
        if ($request->isXmlHttpRequest()) {

            $thisCart = $this->getDoctrine()
            ->getRepository(Cart::class)
            ->createQueryBuilder('c')
            ->where('c.user = :user')
            ->setParameter('user', $user)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
            $thisCart->AddArticle($article);
            $manager->persist($thisCart);
            
            //verifier si l'article est deja présent dans le panier
            $lesLignes = $thisCart->getLigneCarts();
            //si il y a des lignes dans le cart
            if(!$lesLignes->isEmpty()) {
                // Create Var isfound
                $isfound = 0;
                // pour chaque ligne des lignes du cart 
                foreach($lesLignes as $laligne){
                    // recuperer l'article de la ligne
                    $articleLigne = $laligne->getArticle();
                    // compare l'id de l'article de la ligne avec l'objet article
                    if($articleLigne == $article){

                         //augmente la quantité de l'article dans la ligne
                        $quantityArticle = $laligne->getQuantity() + 1;
                        $laligne->setQuantity($quantityArticle);

                        $ligne = $laligne;       
                        
                        $isfound = 1;
                    }
                }

                if(!$isfound){
                    // si aucun article correspond créer une nouvelle ligne pour l'article
                    $ligne = new ligneCart();
                    $ligne->setCart($thisCart)
                          ->setQuantity(1)
                          ->setArticle($article);
                }
                
            } else {
                // si aucune ligne créer une nouvelle
                $ligne = new ligneCart();
                $ligne->setCart($thisCart)
                      ->setQuantity(1)
                      ->setArticle($article);
            }
                    
            
            $manager->persist($ligne);         
            $manager->flush();
         
            $response = new JsonResponse("1");
            return $response;

        }

    }

    /**
     * @Route("/panier/commande/facturation/{valid}", name="commander")
     */
    public function commander($valid = null, UserInterface $user, Request $request)
    {

        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();

        $infoUser = $user->getInfoUser();

        if(!$valid){
            return $this->redirectToRoute('home');
        }

        if (!$infoUser) {
            $infoUser = new InfoUser();
            $infoUser->setUser($user);
        }

       
        // creation du form 
        $formInfo = $this->createForm(InfoUserType::class, $infoUser);
        $formInfo->handleRequest($request);

        $submit = 0;

        if ($formInfo->isSubmitted() && $formInfo->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infoUser);
            $entityManager->flush();

            $submit = 1;

            $this->addFlash('success', 'Facturation enregistrées');
        }

        

        return $this->render('\panier\facturation.html.twig', [
            'infoUser' => $infoUser,
            'formInfo' => $formInfo->createView(),
            'categories' => $categories,
            'marques' => $marques,
            'submit' => $submit


        ]);
    }

    /**
     * @Route("/panier/commande/infolivraison/{step}", name="infolivraison")
     */

    public function livraison($step = null, UserInterface $user, Request $request)
    {
        if($step != 1){
            return $this->redirectToRoute('commander');
        }

        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();

        $infoLivraison = $user->getUser();


        if (!$infoLivraison) {
            $infoLivraison = new LivraisonOrder();
            $infoLivraison->setUser($user);
        }

        $formLivraison = $this->createForm(LivraisonType::class, $infoLivraison);
        $formLivraison->handleRequest($request);

        $submit = 0;

        if ($formLivraison->isSubmitted() && $formLivraison->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infoLivraison);
            $entityManager->flush();

            $this->addFlash('success', 'Livraison enregistrées');

            $submit = 1;

        }
            return $this->render('\panier\commande.html.twig', [
                'LivraisonOrder' => $infoLivraison,
                'formLivraison' => $formLivraison->createView(),
                'categories' => $categories,
                'marques' => $marques,
                'submit' => $submit
    
    
            ]);

    }


    /**
     * @Route("/panier/commande/paiement/{choice}", name="paiement")
     */
    public function payer($choice = null)
    {

        $repoPaiement = $this->getDoctrine()->getRepository(ModePaiement::class);
        $modesPaiement = $repoPaiement->findAll();
        
         
          //si l'user a choisit un mode de paiement
          if($choice != null){
            
            $resultChoice = $repoPaiement->find($choice);
            //si le choix n'existe pas
            if(!$resultChoice){
                return $this->redirectToRoute('paiement');
            }else{
                //new session pour recup les sessions
                $session = new Session();
                //créer session pour l'user
                $session->set('modePaiement', $choice);
                //recup une session définis
                //$sessionModePaiement = $session->get('modePaiement');
                return $this->redirectToRoute('livraison');
            }
        }

        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();
        $repo = $this->getDoctrine()->getRepository(ModePaiement::class);

        $methods = $repo->findAll();


        return $this->render('\panier\paiement.html.twig', [
            'ModePaiement' => $methods,
            'categories' => $categories,
            'marques' => $marques

        ]);
    }

    /**
     * @Route("/panier/commande/livraison/{choice}", name="livraison")
     */
    public function livreur($choice = null)
    {

        $repoLivraison = $this->getDoctrine()->getRepository(ModeLivraison::class);
        $modesLivraison = $repoLivraison->findAll();

        //si l'user a choisit un mode de livraison
        if($choice != null){
            
            $resultChoice = $repoLivraison->find($choice);
            //si le choix n'existe pas
            if(!$resultChoice){
                return $this->redirectToRoute('livraison');
            }else{
                //new session pour recup les sessions
                $session = new Session();
                //créer session pour l'user
                $session->set('modeLivraison', $choice);
                //recup une session définis
                //$sessionModeLivraison = $session->get('modeLivraison');
                return $this->redirectToRoute('checkout');
            }
        }

        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();

        $repo = $this->getDoctrine()->getRepository(ModeLivraison::class);
        $livreurs = $repo->findAll();

        return $this->render('\panier\livraison.html.twig', [
            'ModeLivraison' => $livreurs,
            'categories' => $categories,
            'marques' => $marques
        ]);
    }
    /**
     * @Route("/panier/commande/checkout/", name="checkout")
     */
    public function finaliser($choice = null)
    {
        
        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();

        return $this->render('\panier\checkout.html.twig', [
            'categories' => $categories,
            'marques' => $marques
            
        ]);

    }

    /**
     * @Route("/panier/supprimer", name="delete")
     */
    public function supprimer(Request $request, UserInterface $user, ObjectManager $manager)
    {
        if($request->isXmlHttpRequest()){

            $thisCart = $user->getCart();

            $id = $request->request->get('id');

            $reparticle = $this->getDoctrine()->getRepository(LigneCart::class);
            $article = $reparticle->find($id);

            //supprime la ligne de la collection des lignes du cart
            $thisCart->removeLigneCart($article);
            
            // supprime la ligne dans la table ligne_cart
            $sql = "delete from ligne_cart where id = $id ";
            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();


            $manager->persist($thisCart);
            $manager->flush();

            $response = new JsonResponse("1");
            return $response;
        }

    }

    /**
     * @Route("/panier/retirer/{id}", name="remove_one")
     */
    public function remove(Article $article, Request $request, UserInterface $user, ObjectManager $manager){

        if($request->isXmlHttpRequest()){

            //recup les lignes du cart
            $thisCart = $user->getCart();
            $lesLignes = $thisCart->getLigneCarts();

            //trouver la ligne avec le bon article
            foreach($lesLignes as $ligne){

                $ligneArticle = $ligne->getArticle();

                if($ligneArticle == $article){

                    // une fois trouver retire 1 a la quantité
                    $quantityArticle = $ligne->getQuantity();

                        $quantityArticle = $ligne->getQuantity() - 1;
                        $ligne->setQuantity($quantityArticle);
                    

                    $manager->persist($ligne);         
                    $manager->flush();
         
                    $response = new JsonResponse("1");
                    return $response;
                }
            }

        }
    }



}
