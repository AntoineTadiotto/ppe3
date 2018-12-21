<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setTitle("Souris")
                 ->setDescription("les souris")
                 ->setImage("img/souris.jpg");
        $manager->persist($category);

 
        $category = new Category();
        $category->setTitle("Clavier")
                 ->setDescription("les claviers")
                 ->setImage("img/clavier.jpg");
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("Casque audio")
                 ->setDescription("les casque audios")
                 ->setImage("img/casque.jpg");
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("Tapis")
                 ->setDescription("les tapis de souris")
                 ->setImage("img/tapis.jpg");
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("Clé usb")
                 ->setDescription("Les clés usb")
                 ->setImage("img/usb.jpg");
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("Siège bureau/ordinateur")
                 ->setDescription("")
                 ->setImage("img/chaise.jpg");
        $manager->persist($category);
        
        
        
        $manager->flush();

    }
}
