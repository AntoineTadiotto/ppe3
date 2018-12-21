<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ModePaiement;

class ModePaiementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $modeP = new ModePaiement();
        $modeP->setLibelle("Paypal")
              ->setContent("paiement par paypal")
              ->setImage("img/Paypal.jpg");
        $manager->persist($modeP);

        $manager->flush();
    }
}
