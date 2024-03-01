<?php

declare(strict_types=1);

namespace App\Meal\Domain\Repository;

use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;

interface IMealRepository
{
    public function persist(Meal $meal): Meal;

    public function getOne(int $id): Meal;

    public function delete(int ...$ids): void;

    /**
     * @param int ...$ids
     * @return Collection<Meal>
     */
    public function getAll(int ...$ids): Collection;
}