<?php

namespace App\Meal\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Infrastructure\Meal\State\MealProcessor;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Infrastructure\ApiPlatform\Input\MealInput;
use App\Meal\Infrastructure\ApiPlatform\Processor\CreateMealProcessor;
use App\Meal\Infrastructure\ApiPlatform\Processor\DeleteMealProcessor;
use App\Meal\Infrastructure\ApiPlatform\Provider\MealItemProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/meals/{id}',
            requirements: ['id' => '\d+'],
            provider: MealItemProvider::class
        ),
        new Post(
            uriTemplate: '/meals/',
            input: MealInput::class,
            processor: CreateMealProcessor::class
        ),
        new Delete(
            uriTemplate: '/meals/{id}',
            requirements: ['id' => '\d+'],
            processor: DeleteMealProcessor::class
        )
    ],
    routePrefix: '/cook'
)]
final readonly class MealResource
{
    public function __construct(
        public string $name,
        public int    $price,
        public ?int   $id = null
    ) {}

    public static function fromDomain(Meal $meal): MealResource
    {
        return new self(
            $meal->name,
            $meal->price,
            $meal->id
        );
    }

    public function with(...$properties): self
    {
        return new self(
            $properties['name'] ?? $this->name,
            $properties['price'] ?? $this->price,
            $properties['id'] ?? $this->id
        );

        //$meal->setCook($this->getCook());

        //return $meal;
    }
}