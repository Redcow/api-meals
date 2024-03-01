<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Repository\IMealRepository;

#[CommandHandler]
final readonly class DeleteMealCommandHandler
{
    public function __construct(
        private IMealRepository $repository
    ) {}

    public function __invoke(DeleteMealICommand $command): void
    {
        $this->repository->delete($command->id);
    }
}