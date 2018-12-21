<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use App\DataFixtures\MarqueFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Souris']);

        $repoMar = $manager->getRepository(Marque::class);
        $marque = $repoMar->findOneBy(['nom' => 'logitech']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Souris g300S logitech")
            ->setDescription("La souris Logitech Gaming Mouse G300s est équipée de neuf commandes programmables
                 qui vous permettent d'assigner les commandes aux boutons idéalement placés. La mémoire intégrée vous
                  permet d'enregistrer jusqu'à trois profils de jeu ou de joueur.")
            ->setImage("img/souris-g300S-logitech.jpg")
            ->setPrix(36);

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }

        $manager->persist($article);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("G502 proteus spectrum")
            ->setDescription("• Résolution capteur : 7000 a 9000 dpi\r\n• Utilisation : Gaming\r\n• Capteur : Optique\r\n• Connexion : Filaire")
            ->setImage("img/souris_logitech_G502_Proteus_Spectrum.jpg")
            ->setPrix(75);

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }

        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Clavier']);

        $repoMar = $manager->getRepository(Marque::class);
        $marque = $repoMar->findOneBy(['nom' => 'logitech']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Clavier LOGITECH K280E - Filaire")
            ->setDescription("Clavier filaire K280e : coque renforcée - Repose-poignets pleine taille confortable - Conception résistante aux éclaboussures - Profil élégant et moderne - Touches quasi silencieuses, ultra-plates et souples à la saisie - touches conçues pour supporter jusqu\'à 10 millions de frappes - Touches de raccourci - Pattes d\'inclinaison - Centre de témoins lumineux - Installation prête à l\'emploi USB")
            ->setImage("img/clavier-logitech-k280e.jpg")
            ->setPrix(30);

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }

        $manager->persist($article);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Logitech G810 Orion Spectrum RGB")
            ->setDescription($faker->text())
            ->setImage("img/clavier-logi-orion-g810.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Casque audio']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Logitech G Pro Casque")
            ->setDescription($faker->text())
            ->setImage("img/casque-logi-gpro.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);


        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Tapis']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Tapis de souris logitech g640")
            ->setDescription($faker->text())
            ->setImage("img/tapis-logi-g640.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Souris']);

        $repoMar = $manager->getRepository(Marque::class);
        $marque = $repoMar->findOneBy(['nom' => 'Steelseries']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Souris steelseries rival 100")
            ->setDescription($faker->text())
            ->setImage("img/steelseries-rival-100.png")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);


        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Souris steelseries rival 500")
            ->setDescription($faker->text())
            ->setImage("img/steelseries-rival-500.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);


        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Clavier']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Clavier steelseries apex m750 gaming")
            ->setDescription($faker->text())
            ->setImage("img/steelseries-clavier-apex-m750.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Clavier steelseries apex m500 gaming")
            ->setDescription($faker->text())
            ->setImage("img/steelseries-clavier-apex-m500.png")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Casque audio']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Casque steelseries arctis 7")
            ->setDescription($faker->text())
            ->setImage("img/steelseries-arctis7.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Souris']);

        $repoMar = $manager->getRepository(Marque::class);
        $marque = $repoMar->findOneBy(['nom' => 'Razer']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("souris RAZER DEATHADDER CHROMA")
            ->setDescription($faker->text())
            ->setImage("img/razer-deathadder-chroma.JPEG")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("souris razer taipan")
            ->setDescription($faker->text())
            ->setImage("img/razer-taipan.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Siège bureau/ordinateur']);

        $repoMar = $manager->getRepository(Marque::class);
        $marque = $repoMar->findOneBy(['nom' => 'Dxracer']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("DXRACER KING K11-NR")
            ->setDescription($faker->text())
            ->setImage("img/dxracer-king.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));


        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);

        $repoCat = $manager->getRepository(Category::class);
        $categorie = $repoCat->findOneBy(['title' => 'Clé usb']);

        $repoMar = $manager->getRepository(Marque::class);
        $marque = $repoMar->findOneBy(['nom' => 'logitech']);

        $article = new Article();
        $article->setCategory($categorie)
            ->setMarque($marque)
            ->setTitle("Clé usb logitech")
            ->setDescription($faker->text())
            ->setImage("img/Cle-Usb-Logitech.jpg")
            ->setPrix($faker->numberBetween($min = 30, $max = 120));

        for ($i = 1; $i <= 3; $i++) {
            $comment = new Comment();
            $comment->setArticle($article)
                ->setAuthor($faker->userName())
                ->setContent($faker->text())
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($comment);
        }
        $manager->persist($article);





        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            MarqueFixtures::class
        );
    }
}
