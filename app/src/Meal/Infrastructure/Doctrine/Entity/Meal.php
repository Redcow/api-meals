<?php

namespace App\Meal\Infrastructure\Doctrine\Entity;

use App\Meal\Infrastructure\Doctrine\Repository\MealRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Common\Infrastructure\Doctrine\Entity\User;
use \App\Meal\Domain\Entity\Meal as DomainMeal;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 127)]
    private ?string $name = null;

    /**
     * Price of a meal in € cents
     */
    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CookUser $cook = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: false)]
    private int $quantity = 0;

    public function __construct() {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public static function fromDomain (DomainMeal $meal): self
    {
        $self = new self();

        $self->name = $meal->name;
        $self->price = $meal->price;
        $self->quantity = $meal->quantity;

        return $self;
    }

    public function asDomain(bool $withCook = false): DomainMeal
    {
        return new DomainMeal(
            name: $this->name,
            price: $this->price,
            cook: $withCook ? $this->cook->asDomain() : null,
            quantity: $this->quantity,
            id: $this->id
        );
    }

    public function getCook(): ?CookUser
    {
        return $this->cook;
    }

    public function setCook(?User $cook): static
    {
        $this->cook = $cook;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
