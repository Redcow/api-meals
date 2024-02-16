<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandInterface;
use App\Meal\Domain\Entity\Meal;

/**
 * @implements CommandInterface<Meal>
 */
final readonly class CreateMealCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public int $price
    ){}
}