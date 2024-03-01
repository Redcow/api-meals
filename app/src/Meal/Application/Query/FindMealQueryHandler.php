<?php

declare(strict_types=1);

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\IMealRepository;

#[QueryHandler]
final readonly class FindMealQueryHandler
{
    public function __construct(
        private IMealRepository $repository
    ) {}

    public function __invoke(FindMealIQuery $query): Meal
    {
        return $this->repository->getOne($query->id);
    }
}