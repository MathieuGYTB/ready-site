<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'Bill', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName:"nom", nullable: false)]
    private ?User $nom = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'Bill',cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName:"prenom",nullable: false)]
    private ?User $prenom = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'Bill',cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName:"email",nullable: false)]
    private ?User $email = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 5)]
    private ?string $money = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?user
    {
        return $this->nom;
    }

    public function setNom(user $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?user
    {
        return $this->prenom;
    }

    public function setPrenom(user $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?user
    {
        return $this->email;
    }

    public function setEmail(user $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMoney(): ?string
    {
        return $this->money;
    }

    public function setMoney(string $money): self
    {
        $this->money = $money;

        return $this;
    }
}
