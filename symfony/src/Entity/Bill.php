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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 5)]
    private ?string $money = null;

    #[ORM\OneToOne(mappedBy: 'billId', cascade: ['persist', 'remove'])]
    private ?User $userId = null;

    public function getId(): ?int
    { 
        return $this->id;
    }

    public function setId(int $id): ?int
    {
        $this->id = $id;

        return $this->id;
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

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        // unset the owning side of the relation if necessary
        if ($userId === null && $this->userId !== null) {
            $this->userId->setBillId(null);
        }

        // set the owning side of the relation if necessary
        if ($userId !== null && $userId->getBillId() !== $this) {
            $userId->setBillId($this);
        }

        $this->userId = $userId;

        return $this;
    }
}
