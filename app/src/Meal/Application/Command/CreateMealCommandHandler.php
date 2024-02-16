<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryInterface;

#[CommandHandler]
final readonly class CreateMealCommandHandler
{
    public function __construct(
        private MealRepositoryInterface $repository
    ) {}

    public function __invoke(CreateMealCommand $command): Meal
    {
        $meal = new Meal(
            $command->name,
            $command->price
        );

        return $this->repository->persist($meal);
    }
}