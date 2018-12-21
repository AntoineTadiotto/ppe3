<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $marque = new Marque();
        $marque->setNom("logitech")
               ->setImage("img/logitech.jpg");

        $manager->persist($marque);

        $marque = new Marque();
        $marque->setNom("Steelseries")
               ->setImage("img/steelseries.png");

        $manager->persist($marque);

        $marque = new Marque();
        $marque->setNom("Razer")
               ->setImage("img/razer.png");

        $manager->persist($marque);

        $marque = new Marque();
        $marque->setNom("Dxracer")
               ->setImage("img/dxracer.png");

        $manager->persist($marque);

        $manager->flush();
    }
}
