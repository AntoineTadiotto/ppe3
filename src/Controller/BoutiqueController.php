<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\CategoryFixtures;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Form\ArticleType;
use App\Form\CommentType;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Marque;
use App\Entity\Comment;






class BoutiqueController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() {

        $repo = $this->getDoctrine()->getRepository(Category::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        
        $marques = $repoM->findAll();
    

        $categories = $repo->findAll();
        
    return $this->render('boutique/home.html.twig', [
        'marques' => $marques,
        'categories' => $categories
    ]);
    }

    /**
     * @Route("/boutique/marque", name="marque")
     */
    public function marque(){
        $repo = $this->getDoctrine()->getRepository(Marque::class);
        $repocat = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repocat->findAll();
    
        $marques = $repo->findAll();
    
        return $this->render('boutique/marque.html.twig',[
            'marques' => $marques,
            'categories' => $categories
        ]);
    }
    
    /**
     * @Route("/boutique/categories", name="boutique")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        
        $marques = $repoM->findAll();
    

        $categories = $repo->findAll();
        
        return $this->render('boutique/index.html.twig', [
            'controller_name' => 'BoutiqueController',
            'categories' => $categories,
            'marques' => $marques
            ]);
        }
    
    /**
     * @Route("/boutique/new", name="create_article")
     * @Route("/boutique/{id}/edit", name="edit_article")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager){

        if(!$article){
            $article = new Article();
        }       

        $form = $this->createForm(ArticleType::class, $article); //créer le form basé sur l'articleType

        $form->handleRequest($request); // analyse de la requête 

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($article);  //fait persister l'article pour l'ajouter a la base de donnée
            $manager->flush();
            
            return $this->redirectToRoute('article', ['id' => $article->getId()]); // redirige après la création de l'article
            
        }

        

        return $this->render('boutique/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null //créer un moyen de savoir si c'est une modification d'article ou non
        ]);
        
    }

    /**
     * @Route("/boutique/categories/{id}", name="category")
     */
    public function category($id){
        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();


        $repo = $this->getDoctrine()->getRepository(Article::class);
        

        $articles = $repo->findBy(['category' => $id]);

        $oui = $this->getDoctrine()->getRepository(Category::class);

        $category = $oui->findBy(['id' => $id]);
         
        return $this->render('boutique/category.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'categories' => $categories,
            'marques' => $marques
        ]);
    }
    /**
     * @Route("/boutique/marque/{id}", name="select_marque")
     */
    public function select_marque($id){

        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();

        $repo = $this->getDoctrine()->getRepository(Article::class);
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        $repoC = $this->getDoctrine()->getRepository(Category::class);

        $articles = $repo->findBy(['marque' => $id]);

        $laMarque = $repoM->findBy(['id' => $id]);
        
        $laCategory = $repoC->findBy(['id' => $id]);

        return $this->render('boutique/select_marque.html.twig', [
            'articles' => $articles,
            'laMarque' => $laMarque,
            'laCategory' => $laCategory,
            'categories' => $categories,
            'marques' => $marques
        ]);
    
    }

    /**
     * @Route("/boutique/article/{id}", name="article")
     */
    public function show($id, Request $request, ObjectManager $manager, Article $article){
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);
        
        $repoAllCat = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repoAllCat->findAll(); 

        $repoAllMar = $this->getDoctrine()->getRepository(Marque::class);
        $marques = $repoAllMar->findAll();
        $repoM = $this->getDoctrine()->getRepository(Marque::class);
        $repoC = $this->getDoctrine()->getRepository(Category::class);
        
        

        // création d'un commentaire
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);
                    
                    

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article', ['id' => $id]);

        }
        
        return $this->render('boutique/show.html.twig',[
            'article' => $article,
            'commentForm' => $form->createView(),
            'marques' => $marques,
            'categories' => $categories
        ]);
    }




}
