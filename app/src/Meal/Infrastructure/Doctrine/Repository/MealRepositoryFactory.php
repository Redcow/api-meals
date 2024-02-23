<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\AppCacheInterface;
use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryInterface;
use App\Meal\Infrastructure\Doctrine\Repository\MealRepository as MealDoctrineRepository;

class MealRepositoryFactory implements MealRepositoryInterface
{
    private MealRepositoryInterface $repository;

    public function __invoke(
        MealDoctrineRepository $mealDoctrineRepository,
        AppCacheInterface $cache
    ): MealRepositoryInterface
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