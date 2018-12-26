<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\InfoUser;
use App\Form\InfoUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\LigneCommande;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(UserInterface $user, Request $request, ObjectManager $manager)
    {

        
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        
        $marques = $repoM->findAll();
    

        $categories = $repo->findAll();
      
            $infoUser = $user->getInfoUser();
            if(!$infoUser){
                $infoUser = new InfoUser();
                $infoUser->setUser($user);
            }
            // creation du form 
            $formInfo = $this->createForm(InfoUserType::class, $infoUser);
            $formInfo->handleRequest($request);
    
            if($formInfo->isSubmitted() && $formInfo->isValid()){
    
         
                $manager->persist($infoUser);
                $manager->flush();
    
                $this->addFlash('success','Informations enregistrées');
            
            }
            
            //récupérer les commandes de l'utilisateur
            $commandes = $this->getDoctrine()->getRepository(Commande::class)->findBy([
                "user" => $user,
                
            ]);

            foreach($commandes as $commande){
                // $lignes = $this->getDoctrine()->getRepository(LigneCommande::class)->findBy([
                //     "commande" => $commande,
                // ]);
                // $lignes = $commande->getLigneCommandes();
            }
            $lignes = $this->getDoctrine()->getRepository(LigneCommande::class)->findBy([
                "commande" => $commandes,
            ]);

            




        
        return $this->render('user/profil.html.twig', [
            'infoUser' => $infoUser,
            'formInfo' => $formInfo->createView(),
            'categories' => $categories,
            'marques' => $marques,
            'commandes' => $commandes,
            'lignes' => $lignes
        ]);
    }
}
