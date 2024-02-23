<?php

namespace App\Order\Domain\Entity;

final readonly class Article
{
    public function __construct(
        public string $name,
        public int $quantity,
        public int $price,
        public ?int $mealId = null,
        public ?int $id = null
    ){}

    public function getPrice(): float
    {
        return $this->price * $this->quantity;
        // TODO TVA
    }
}