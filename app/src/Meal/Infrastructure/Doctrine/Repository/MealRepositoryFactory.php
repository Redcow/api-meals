<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryInterface;
use App\Meal\Infrastructure\Doctrine\Repository\MealRepository as MealDoctrineRepository;
use App\Meal\Infrastructure\Redis\Cache\CacheMealRepositoryDecorator;

class MealRepositoryFactory implements MealRepositoryInterface
{
    private MealRepositoryInterface $repository;

    public function __invoke(MealDoctrineRepository $mealDoctrineRepository): MealRepositoryInterface
    {
        $this->repository = new CacheMealRepositoryDecorator($mealDoctrineRepository);
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
}