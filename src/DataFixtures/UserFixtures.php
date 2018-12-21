<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\InfoUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\LivraisonOrder;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 50; $i++){
            $user = new User();
            $user->setUsername($faker->userName())
                 ->setEmail($faker->email())
                 ->setPassword($faker->password()) 
                 ->setEnabled(true);
            $cart = new Cart();
            $user->setCart($cart);

            $mail2 = $user->getEmail();
            $user->setEmailCanonical($mail2);

            $password2 = $user->getPassword();
            $user->setPassword($password2);
            
            $user->setLastLogin($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));

            $manager->persist($user);

            $manager->persist($cart);  

            $infoUser = new InfoUser();
            $infoUser->setUser($user)
                     ->setNom($faker->firstName())
                     ->setPrenom($faker->lastName())
                     ->setAdresse1($faker->address())
                     ->setAdresse2($faker->secondaryAddress())
                     ->setCodepostal($faker->biasedNumberBetween($min = 40000, $max = 10000, $function = 'sqrt'))
                     ->setVille($faker->city())
                     ->setTelephone($faker->mobileNumber());

            $manager->persist($infoUser);

            $livr = new LivraisonOrder();
            $livr->setUser($user)
                     ->setNom($faker->firstName())
                     ->setPrenom($faker->lastName())
                     ->setAdresse1($faker->address())
                     ->setAdresse2($faker->secondaryAddress())
                     ->setCodepostal($faker->biasedNumberBetween($min = 40000, $max = 10000, $function = 'sqrt'))
                     ->setVille($faker->city())
                     ->setTelephone($faker->mobileNumber());

            $manager->persist($livr);



            
                   
        }

        $manager->flush();
    }
}
