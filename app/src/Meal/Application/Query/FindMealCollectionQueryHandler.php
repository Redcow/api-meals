<?php

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\IMealRepository;

#[QueryHandler]
final readonly class FindMealCollectionQueryHandler
{
    public function __construct(
        private IMealRepository $repository
    ){}

    /**
     * @param FindMealCollectionIQuery $query
     * @return Collection<Meal>
     */
    public function __invoke(FindMealCollectionIQuery $query): Collection
    {
        return $this->repository->getAll(...$query->ids);
    }
}