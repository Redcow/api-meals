<?php

declare(strict_types=1);

namespace App\Meal\Domain\Entity;

class Meal
{
    public function __construct(
        public string $name,
        public int $price,
        public ?int $id = null
    ){}

    public function with(...$properties): self
    {
        return new self(
            $properties['name'] ?? $this->name,
            $properties['price'] ?? $this->price,
            $properties['id'] ?? $this->id
        );
    }
}