<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommandeArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {   

        $repoCommande = $manager->getRepository(Commande::class);
        $Commandes = $repoCommande->findAll();

        $repoArticle = $manager->getRepository(Article::class);
        

        $faker = \Faker\Factory::create('fr_FR');

        $conn = $manager->getConnection();

        foreach($Commandes as $commande){
            // requete qui selectionne un id d'article aléatoire
            $sql = "
            SELECT t.id
            FROM article as t
            ORDER BY RAND()
            LIMIT 1
            "; 

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            //on stock l'id dans la variable
            $articleid = $stmt->fetch();
            // on recupère l'article avec le bon id
            $article = $repoArticle->findOneBy(['id' => $articleid]);
            //genère une quantité entre 1 et 3 
            $qte = $faker->numberBetween($min = 1, $max = 3);

            //création de la ligne
            $ligne = new LigneCommande();
            $ligne->setCommande($commande)
                  ->setArticle($article)
                  ->setQuantity($qte);

            $manager->persist($ligne);

        }
      
    

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
           CommandeFixtures::class,

        );
    }
}
