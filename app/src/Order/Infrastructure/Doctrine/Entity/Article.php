<?php

namespace App\Order\Infrastructure\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Meal\Infrastructure\Doctrine\Entity\Meal;
use App\Order\Infrastructure\Doctrine\Repository\ArticleRepository;

use App\Order\Domain\Entity\Article as DomainArticle;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn]
    private ?Meal $meal = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $quantity = null;

    #[ORM\Column(length: 127)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    public static function fromDomain(DomainArticle $article): static
    {
        $self = new self();

        $self->name = $article->name;
        $self->id = $article->id;
        $self->price = $article->price;
        $self->quantity = $article->quantity;

        return $self;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): static
    {
        $this->meal = $meal;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

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
}
