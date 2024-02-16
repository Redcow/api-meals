<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandInterface;

final readonly class DeleteMealCommand implements CommandInterface
{
    public function __construct(
        public int $id
    ){}
}