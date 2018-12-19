<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCart", mappedBy="cart")
     */
    private $ligneCarts;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->ligneCarts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
        }

        return $this;
    }
    public function __toString() {
        return (string) $this->user; }

    /**
     * @return Collection|LigneCart[]
     */
    public function getLigneCarts(): Collection
    {
        return $this->ligneCarts;
    }

    public function addLigneCart(LigneCart $ligneCart): self
    {
        if (!$this->ligneCarts->contains($ligneCart)) {
            $this->ligneCarts[] = $ligneCart;
            $ligneCart->setCart($this);
        }

        return $this;
    }

    public function removeLigneCart(LigneCart $ligneCart): self
    {
        if ($this->ligneCarts->contains($ligneCart)) {
            $this->ligneCarts->removeElement($ligneCart);
            // set the owning side to null (unless already changed)
            if ($ligneCart->getCart() === $this) {
                $ligneCart->setCart(null);
            }
        }

        return $this;
    }
}
