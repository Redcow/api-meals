<?php

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;
use App\Meal\Domain\Repository\IMealRepository;

class MealRepositoryBaseDecorator implements IMealRepository
{
    protected IMealRepository $wrappee;

    function __construct(IMealRepository $wrappee)
    {
        $this->wrappee = $wrappee;
    }

    public function persist(Meal $meal): Meal
    {
        return $this->wrappee->persist($meal);
    }

    public function getOne(int $id): Meal
    {
        return $this->wrappee->getOne($id);
    }

    public function delete(int ...$ids): void
    {
        $this->wrappee->delete(...$ids);
    }

    public function getAll(int ...$ids): Collection
    {
        return $this->wrappee->getAll(...$ids);
    }
}