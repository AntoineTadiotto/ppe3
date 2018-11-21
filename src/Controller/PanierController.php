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


        $thisCart = $thisCart->getArticles();

        
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        
        $marques = $repoM->findAll();
    

        $categories = $repo->findAll();


        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'thisCart' => $thisCart,
            'categories' => $categories,
            'marques' => $marques
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
            //SAVOIR SI L'ARTICLE EXISTE DEJA DANS LA COLLECTION DU PANIER DE L'USER
            $thisCart = $this->getDoctrine()
                ->getRepository(Cart::class)
                ->createQueryBuilder('c')
                ->where('c.user = :user')
                ->setParameter('user', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
            $thisCart->addArticle($article);
            $manager->persist($thisCart);
            $manager->flush();

            $response = new JsonResponse("1");
            return $response;
        }

    }


    public function supprimer($id)
    {

    }
    /**
     * @Route("/panier/commande/", name="commander")
     */
    public function commander(UserInterface $user, Request $request)
    {
        $infoUser = $user->getInfoUser();


        if (!$infoUser) {
            $infoUser = new InfoUser();
            $infoUser->setUser($user);
        }

        $infoFacture = $user->getUser();


        if (!$infoFacture) {
            $infoFacture = new LivraisonOrder();
            $infoFacture->setUser($user);
        }
        // creation du form 
        $formInfo = $this->createForm(InfoUserType::class, $infoUser);
        $formInfo->handleRequest($request);

        $formFacture = $this->createForm(LivraisonType::class, $infoFacture);
        $formFacture->handleRequest($request);

        if ($formInfo->isSubmitted() && $formInfo->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infoUser);
            $entityManager->flush();



            $this->addFlash('success', 'Informations enregistrées');
        }

        if ($formFacture->isSubmitted() && $formFacture->isValid()) {

            $entity = $this->getDoctrine()->getManager();
            $entity->persist($infoFacture);
            $entity->flush();

            $this->addFlash('success', 'Livraison enregistrées');

        }

        return $this->render('\panier\commande.html.twig', [
            'infoUser' => $infoUser,
            'LivraisonOrder' => $infoFacture,
            'formInfo' => $formInfo->createView(),
            'formFacture' => $formFacture->createView()


        ]);
    }
    /**
     * @Route("/panier/commande/paiement/", name="paiement")
     */
    public function payer()
    {
        $repo = $this->getDoctrine()->getRepository(ModePaiement::class);
        $methods = $repo->findAll();


        return $this->render('\panier\paiement.html.twig', [
            'ModePaiement' => $methods,

        ]);
    }

    /**
     * @Route("/panier/commande/livraison/", name="livraison")
     */
    public function livreur()
    {
        $repo = $this->getDoctrine()->getRepository(ModeLivraison::class);
        $livreurs = $repo->findAll();

        return $this->render('\panier\livraison.html.twig', [
            'ModeLivraison' => $livreurs,
        ]);
    }
    /**
     * @Route("/panier/commande/checkout/", name="checkout")
     */
    public function finaliser()
    {
        
        return $this->render('\panier\checkout.html.twig', [
            
        ]);

    }




}
