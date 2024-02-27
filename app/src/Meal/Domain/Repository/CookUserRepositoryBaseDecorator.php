<?php

namespace App\Meal\Domain\Repository;

use App\Meal\Domain\Entity\CookUser;

class CookUserRepositoryBaseDecorator implements CookUserRepositoryInterface
{
    protected CookUserRepositoryInterface $wrappee;

    public function __construct(CookUserRepositoryInterface $wrappee)
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