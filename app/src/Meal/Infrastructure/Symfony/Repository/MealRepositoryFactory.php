<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\Symfony\Repository;

use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\MealRepositoryInterface;
use App\Meal\Infrastructure\Redis\Cache\CacheMealRepositoryDecorator;
use App\Repository\MealRepository as MealDoctrineRepository;

class MealRepositoryFactory implements MealRepositoryInterface
{
    private MealRepositoryInterface $repository;

    /*public function __construct (
        MealDoctrineRepository $mealDoctrineRepository
    )
    {
        // ajout du décorateur de cache Redis
        $this->repository = new CacheMealRepositoryDecorator($mealDoctrineRepository);
    }*/

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