<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\IAppCache;
use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\IMealRepository;
use App\Meal\Infrastructure\Doctrine\Repository\MealRepository as MealDoctrineRepository;

class MealRepositoryFactory implements IMealRepository
{
    private IMealRepository $repository;

    public function __invoke(
        MealDoctrineRepository $mealDoctrineRepository,
        IAppCache $cache
    ): IMealRepository
    {
        $this->repository = new MealRepositoryCacheDecorator(
            $mealDoctrineRepository,
            $cache
        );

        return $this;
    }

    public function persist(Meal $meal): Meal
    {
        return $this->repository->persist($meal);
    }

    public function getOne(int $id): Meal
    {
        return $this->repository->getOne($id);
    }

    public function delete(int ...$ids): void
    {
        $this->repository->delete(...$ids);
    }

    public function getAll(int ...$ids): Collection
    {
        return $this->repository->getAll(...$ids);
    }
}