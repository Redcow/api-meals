<?php

declare(strict_types=1);

namespace App\Meal\Domain\Entity;

class Meal
{
    public function __construct(
        public string   $name,
        public int      $price,
        public CookUser $cook,
        public ?int     $id = null
    ){}

    public function with(...$properties): self
    {
        return new self(
            name: $properties['name'] ?? $this->name,
            price: $properties['price'] ?? $this->price,
            cook: $properties['maker'] ?? $this->cook,
            id: $properties['id'] ?? $this->id
        );
    }
}