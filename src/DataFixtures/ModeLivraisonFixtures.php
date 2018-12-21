<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ModeLivraison;

class ModeLivraisonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $mode = new ModeLivraison();
        $mode->setTitle("Gratuit")
             ->setContent("C'est gratuit")
             ->setImage("img/gratuit.jpg")
             ->setPrice(0);

        $manager->persist($mode);

        $manager->flush();
    }
}
