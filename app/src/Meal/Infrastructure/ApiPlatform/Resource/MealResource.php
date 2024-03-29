<?php

namespace App\Meal\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Infrastructure\ApiPlatform\Input\MealInput;
use App\Meal\Infrastructure\ApiPlatform\Processor\CreateMealProcessor;
use App\Meal\Infrastructure\ApiPlatform\Processor\DeleteMealProcessor;
use App\Meal\Infrastructure\ApiPlatform\Provider\MealItemProvider;

#[ApiResource(
    shortName: 'Meal',
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            provider: MealItemProvider::class
        ),
        new Post(
            uriTemplate: '/',
            input: MealInput::class,
            processor: CreateMealProcessor::class
        ),
        new Delete(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            processor: DeleteMealProcessor::class
        )
    ],
    routePrefix: '/meals'
)]
final readonly class MealResource
{
    public function __construct(
        public string $name,
        public int    $price,
        public ?CookUserResource $cook = null,
        public int $quantity = 0,
        public ?int   $id = null
    ) {}

    public static function fromDomain(Meal $meal): MealResource
    {
        return new self(
            name: $meal->name,
            price: $meal->price,
            cook: CookUserResource::fromDomain($meal->cook),
            quantity: $meal->quantity,
            id: $meal->id
        );
    }

    public function with(...$properties): self
    {
        return new self(
            $properties['name'] ?? $this->name,
            $properties['price'] ?? $this->price,
            $properties['cook'] ?? $this->cook,
            $properties['quantity'] ?? $this->quantity,
            $properties['id'] ?? $this->id
        );
    }
}