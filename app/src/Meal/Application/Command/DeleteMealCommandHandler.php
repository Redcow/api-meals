<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Repository\MealRepositoryInterface;

#[CommandHandler]
final readonly class DeleteMealCommandHandler
{
    public function __construct(
        private MealRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteMealCommand $command): void
    {
        $this->repository->delete($command->id);
    }
}