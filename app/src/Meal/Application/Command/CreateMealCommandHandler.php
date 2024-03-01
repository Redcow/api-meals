<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\ICookUserRepository;
use App\Meal\Domain\Repository\IMealRepository;

#[CommandHandler]
final readonly class CreateMealCommandHandler
{
    public function __construct(
        private IMealRepository     $repository,
        private ICookUserRepository $cookRepository
    ) {}

    public function __invoke(CreateMealICommand $command): Meal
    {
        $cook = $this->cookRepository->getById($command->makerId);

        $meal = new Meal(
            $command->name,
            $command->price,
            $cook
        );

        return $this->repository->persist($meal);
    }
}