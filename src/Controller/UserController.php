<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Category;
use App\Form\InfoUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

        
        return $this->render('user/profil.html.twig', [
            'infoUser' => $infoUser,
            'formInfo' => $formInfo->createView(),
            'categories' => $categories,
            'marques' => $marques
        ]);
    }
}
