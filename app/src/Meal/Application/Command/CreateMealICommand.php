<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\ICommand;
use App\Meal\Domain\Entity\Meal;

/**
 * @implements ICommand<Meal>
 */
final readonly class CreateMealICommand implements ICommand
{
    public function __construct(
        public string $name,
        public int $price,
        public int $makerId
    ){}
}