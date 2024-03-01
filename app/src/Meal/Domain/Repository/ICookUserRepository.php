<?php

namespace App\Meal\Domain\Repository;

use App\Meal\Domain\Entity\CookUser;

interface ICookUserRepository
{
    public function persist(CookUser $cook): CookUser;

    public function getById(int $id): CookUser;
}