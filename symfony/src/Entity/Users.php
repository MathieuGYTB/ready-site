<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 8)]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?int $cardNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $cvc = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cardEndDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $bill = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCardNumber(): ?int
    {
        return $this->cardNumber;
    }

    public function setCardNumber(?int $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCvc(): ?int
    {
        return $this->cvc;
    }

    public function setCvc(?int $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getCardEndDate(): ?\DateTimeInterface
    {
        return $this->cardEndDate;
    }

    public function setCardEndDate(?\DateTimeInterface $cardEndDate): self
    {
        $this->cardEndDate = $cardEndDate;

        return $this;
    }

    public function getBill(): ?int
    {
        return $this->bill;
    }

    public function setBill(?int $bill): self
    {
        $this->bill = $bill;

        return $this;
    }
}
