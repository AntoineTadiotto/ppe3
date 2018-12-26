<?php
namespace App\Controller;

// use App\Entity\Cart;
use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Marque;
use App\Form\UserType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {



        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll();

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();
        
        // 1) build the form
        // $cart = new Cart();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //on active par défaut
            //$user->setEnabled(true);
            //add Cart
            $cart = new Cart();
            $user->setCart($cart);
            $cle = md5(microtime(true) * 100000);
            $user->setConfirmationToken($cle);
            //$user->addRole("ROLE_ADMIN");
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($cart);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $username = $user->getUsername();
            $mail = $user->getEmail();
            $sujet = "Activation de votre compte";
            $entete = "From: inscription@masscrab.com";
            $message = "Bienvenue sur MassCrab, pour activer votre compte, veuillez cliquer sur le lien ci-dessous.
            http://projet.tadiotto.fr/public/activation?log=$username&cle=$cle
            ";

            mail($mail, $sujet, $message, $entete);

            $this->addFlash('success', 'Votre compte à bien été enregistré.');
            //return $this->redirectToRoute('login');
        }
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'Inscription',
            'form' => $form->createView(),
            'mainNavRegistration' => true,
            'title' => 'Inscription',
            'marques' => $marques,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/activation", name="activation")
     */
    public function validation()
    {
        $login = $_GET['log'];
        $cle = $_GET['cle'];

        //$stmt = $manager->getRepository()->prepare("SELECT confirmation_token,enabled FROM fos_user WHERE username like :login ");
        // if ($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch()) {
        // }
        
        $sql = "SELECT confirmation_token FROM fos_user WHERE username like :login";
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        if($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch());{
            $clebdd = $row['confirmation_token'];	// Récupération de la clé
            // $actif = $row['enabled']; // $actif contiendra alors 0 ou 1
            
        }
 
// On teste la valeur de la variable $actif récupéré dans la BDD
        // if ($actif == '1') // Si le compte est déjà actif on prévient
        // {
            // echo "Votre compte est déjà actif !";
        // } else // Si ce n'est pas le cas on passe aux comparaisons
        // {
            if ($cle == $clebdd) // On compare nos deux clés	
            {
          // Si elles correspondent on active le compte !	
          $this->addFlash('success', 'Votre compte à bien été activé.');
 
          // La requête qui va passer notre champ actif de 0 à 1
                $sql = "UPDATE fos_user SET enabled = 1 WHERE username like :login ";
                $stmt = $em->getConnection()->prepare($sql);
                $stmt->bindParam(':login', $login);
                $stmt->execute();
            } else // Si les deux clés sont différentes on provoque une erreur...
            {
                echo "Erreur ! Votre compte ne peut être activé...";
                echo($cle);
            }
        // }

        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll();

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();
        return $this->render('boutique/home.html.twig', [
            'marques' => $marques,
            'categories' => $categories
        ]);
    }

}