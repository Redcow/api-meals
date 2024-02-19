<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Cook\Domain\Repository\CookRepositoryInterface;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryInterface;

#[CommandHandler]
final readonly class CreateMealCommandHandler
{
    public function __construct(
        private MealRepositoryInterface $repository,
        private CookRepositoryInterface $cookRepository
    ) {}

    public function __invoke(CreateMealCommand $command): Meal
    {
        $cook = $this->cookRepository->getOne($command->makerId);

        $meal = new Meal(
            $command->name,
            $command->price,
            $cook
        );

        return $this->repository->persist($meal);
    }
}