<?php

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\ICookUserRepository;

class CookUserRepositoryBaseDecorator implements ICookUserRepository
{
    protected ICookUserRepository $wrappee;

    public function __construct(ICookUserRepository $wrappee)
    {
        $this->wrappee = $wrappee;
    }

    public function persist(CookUser $cook): CookUser
    {
        return $this->wrappee->persist($cook);
    }

    public function getById(int $id): CookUser
    {
        return $this->wrappee->getById($id);
    }
}