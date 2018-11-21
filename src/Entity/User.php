<?php 
//src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cart", mappedBy="user", cascade={"persist", "remove"})
     */
    private $cart;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\InfoUser", mappedBy="user", cascade={"persist", "remove"})
     */
    private $infoUser;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LivraisonOrder", mappedBy="user", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        parent::__construct();
                                   //your own logic
    }

    public function getCart() : ? Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart) : self
    {
        $this->cart = $cart;
                  
                                   // set the owning side of the relation if necessary
        if ($this !== $cart->getUser()) {
            $cart->setUser($this);
        }

        return $this;
    }

    public function getInfoUser() : ? InfoUser
    {
        return $this->infoUser;
    }

    public function setInfoUser(? InfoUser $infoUser) : self
    {
        $this->infoUser = $infoUser;
         
                                   // set (or unset) the owning side of the relation if necessary
        $newUser = $infoUser === null ? null : $this;
        if ($newUser !== $infoUser->getUser()) {
            $infoUser->setUser($newUser);
        }

        return $this;
    }

    public function getUser() : ? LivraisonOrder
    {
        return $this->user;
    }

    public function setUser(? LivraisonOrder $user) : self
    {
        $this->user = $user;

                                   // set (or unset) the owning side of the relation if necessary
        $newUser = $user === null ? null : $this;
        if ($newUser !== $user->getUser()) {
            $user->setUser($newUser);
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->username;
    }
}

 