<?php

declare(strict_types=1);

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryInterface;

#[QueryHandler]
final readonly class FindMealQueryHandler
{
    public function __construct(
        private MealRepositoryInterface $repository
    ) {}

    public function __invoke(FindMealQuery $query): Meal
    {
        return $this->repository->getOne($query->id);
    }
}