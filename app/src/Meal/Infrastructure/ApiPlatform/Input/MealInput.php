<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\ApiPlatform\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class MealInput
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 20)]
        public string $name,

        #[Assert\NotNull]
        #[Assert\Positive]
        public int $price
    ) {}
}