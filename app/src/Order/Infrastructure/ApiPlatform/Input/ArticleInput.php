<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\Input;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ArticleInput
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Positive]
        public int $mealId,

        #[Assert\NotNull]
        #[Assert\Positive]
        public int $quantity
    ){}
}