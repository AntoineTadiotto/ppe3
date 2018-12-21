<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LivraisonOrder", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresselivraison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InfoUser", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresseFacturation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeLivraison")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modeLivraison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModePaiement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modePaiement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="commandes")
     */
    private $article;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PaymentOrder", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $paymentOrder;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommande", mappedBy="commande")
     */
    private $ligneCommandes;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresselivraison(): ?LivraisonOrder
    {
        return $this->adresselivraison;
    }

    public function setAdresselivraison(?LivraisonOrder $adresselivraison): self
    {
        $this->adresselivraison = $adresselivraison;

        return $this;
    }

    public function getAdresseFacturation(): ?InfoUser
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(?InfoUser $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    public function getModeLivraison(): ?ModeLivraison
    {
        return $this->modeLivraison;
    }

    public function setModeLivraison(?ModeLivraison $modeLivraison): self
    {
        $this->modeLivraison = $modeLivraison;

        return $this;
    }

    public function getModePaiement(): ?ModePaiement
    {
        return $this->modePaiement;
    }

    public function setModePaiement(?ModePaiement $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
        }

        return $this;
    }

    public function getPaymentOrder(): ?PaymentOrder
    {
        return $this->paymentOrder;
    }

    public function setPaymentOrder(PaymentOrder $paymentOrder): self
    {
        $this->paymentOrder = $paymentOrder;

        // set the owning side of the relation if necessary
        if ($this !== $paymentOrder->getCommande()) {
            $paymentOrder->setCommande($this);
        }

        return $this;
    }
    
    public function __toString() {
        return (string) $this->reference; }

    /**
     * @return Collection|LigneCommande[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->removeElement($ligneCommande);
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }
}


