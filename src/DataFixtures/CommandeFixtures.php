<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Commande;
use App\AT\CommandeBundle\UniqRef;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ModeLivraison;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\ModePaiement;
use App\Entity\LivraisonOrder;


class CommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        $repoUser = $manager->getRepository(User::class);
        $Users = $repoUser->findAll();
        
        $repLivraison = $manager->getRepository(ModeLivraison::class);
        $Modlivr = $repLivraison->findOneBy(['title' => 'Gratuit']);

        $repPaid = $manager->getRepository(ModePaiement::class);
        $ModPaid = $repPaid->findOneBy(['libelle' => 'Paypal']);

        foreach ($Users as $user) {
            
            $info = $user->getInfoUser();

            $id = $user->getId();

            $repoLivraison = $manager->getRepository(LivraisonOrder::class);
            $livraisonorder = $repoLivraison->findOneBy(['user' => $user]);

            $ref = new UniqRef();
            $reference = $ref->generateRef();


            $commande = new Commande();
            $commande->setAdresselivraison($livraisonorder)
                     ->setAdresseFacturation($info)
                     ->setModeLivraison($Modlivr)
                     ->setModePaiement($ModPaid)
                     ->setUser($user)
                     ->setReference($reference)
                     ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));


            $manager->persist($commande);

            
            $commande = new Commande();
            $commande->setAdresselivraison($livraisonorder)
                     ->setAdresseFacturation($info)
                     ->setModeLivraison($Modlivr)
                     ->setModePaiement($ModPaid)
                     ->setUser($user)
                     ->setReference($reference)
                     ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));


            $manager->persist($commande);

            $commande = new Commande();
            $commande->setAdresselivraison($livraisonorder)
                     ->setAdresseFacturation($info)
                     ->setModeLivraison($Modlivr)
                     ->setModePaiement($ModPaid)
                     ->setUser($user)
                     ->setReference($reference)
                     ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));


            $manager->persist($commande);

            
            $commande = new Commande();
            $commande->setAdresselivraison($livraisonorder)
                     ->setAdresseFacturation($info)
                     ->setModeLivraison($Modlivr)
                     ->setModePaiement($ModPaid)
                     ->setUser($user)
                     ->setReference($reference)
                     ->setCreatedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));


            $manager->persist($commande);

            
        }
        


        $manager->flush();
    }

    
    public function getDependencies()
    {
        return array(
           UserFixtures::class,
           ModeLivraisonFixtures::class,
           ModePaiementFixtures::class

        );
    }
}
