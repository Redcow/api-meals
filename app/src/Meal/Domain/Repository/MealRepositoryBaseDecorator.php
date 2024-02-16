<?php

namespace App\Meal\Domain\Repository;

use App\Meal\Domain\Entity\Meal;

class MealRepositoryBaseDecorator implements MealRepositoryInterface
{
    protected MealRepositoryInterface $wrappee;

    function __construct(MealRepositoryInterface $wrappee)
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
}