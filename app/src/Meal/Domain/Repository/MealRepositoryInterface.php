<?php

declare(strict_types=1);

namespace App\Meal\Domain\Repository;

use App\Meal\Domain\Entity\Meal;

interface MealRepositoryInterface
{
    public function persist(Meal $meal): Meal;

    public function getOne(int $id): Meal;

    public function delete(int ...$ids): void;
}