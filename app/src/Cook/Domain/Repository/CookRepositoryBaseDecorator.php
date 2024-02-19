<?php

namespace App\Cook\Domain\Repository;

use App\Common\Domain\Repository\UserRepositoryInterface;
use App\Cook\Domain\Entity\Cook;

readonly class CookRepositoryBaseDecorator implements CookRepositoryInterface
{
    protected UserRepositoryInterface $wrappee;

    public function __construct(UserRepositoryInterface $wrappee)
    {
        $this->wrappee = $wrappee;
    }

    public function persist($user): Cook
    {
        return $this->wrappee->persist($user);
    }

    public function getOne(int $id): Cook
    {
        return $this->wrappee->getOne($id);
    }
}