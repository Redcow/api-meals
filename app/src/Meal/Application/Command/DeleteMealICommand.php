<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\ICommand;

final readonly class DeleteMealICommand implements ICommand
{
    public function __construct(
        public int $id
    ){}
}