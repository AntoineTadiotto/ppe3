<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller {

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) {

        $repo = $this->getDoctrine()->getRepository(Category::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        
        $marques = $repoM->findAll();
    

        $categories = $repo->findAll();
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        //
        $form = $this->get('form.factory')
                ->createNamedBuilder(null)
                ->add('_username', null, ['label' => 'Email'])
                ->add('_password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, ['label' => 'Mot de passe'])
                ->add('ok', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, ['label' => 'Ok', 'attr' => ['class' => 'btn-primary btn-block']])
                ->getForm();
        return $this->render('security/login.html.twig', [
                    'mainNavLogin' => true, 'title' => 'Connexion',
                    'form' => $form->createView(),
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'marques' => $marques,
                    'categories' => $categories
        ]);
            
        return $this->redirectToRoute('home');
    }

  
}
