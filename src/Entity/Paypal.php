<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaypalRepository")
 */
class Paypal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="text")
     */
    private $amount;

    /**
     * @ORM\Column(type="text")
     */
    private $currency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $payer_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payer_paypal_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payer_first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payer_last_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPayerEmail(): ?string
    {
        return $this->payer_email;
    }

    public function setPayerEmail(string $payer_email): self
    {
        $this->payer_email = $payer_email;

        return $this;
    }

    public function getPayerPaypalId(): ?int
    {
        return $this->payer_paypal_id;
    }

    public function setPayerPaypalId(int $payer_paypal_id): self
    {
        $this->payer_paypal_id = $payer_paypal_id;

        return $this;
    }

    public function getPayerFirstName(): ?string
    {
        return $this->payer_first_name;
    }

    public function setPayerFirstName(string $payer_first_name): self
    {
        $this->payer_first_name = $payer_first_name;

        return $this;
    }

    public function getPayerLastName(): ?string
    {
        return $this->payer_last_name;
    }

    public function setPayerLastName(string $payer_last_name): self
    {
        $this->payer_last_name = $payer_last_name;

        return $this;
    }
}
