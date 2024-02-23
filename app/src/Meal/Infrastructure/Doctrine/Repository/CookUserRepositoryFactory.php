<?php

namespace App\Meal\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\AppCacheInterface;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;
use App\Meal\Infrastructure\Doctrine\Repository\CookUserRepository as UserDoctrineRepository;

class CookUserRepositoryFactory implements CookUserRepositoryInterface
{
    private CookUserRepositoryInterface $repository;

    public function __invoke(
        UserDoctrineRepository $userRepository,
        AppCacheInterface $cache
    ): CookUserRepositoryInterface
    {
        $this->repository = new CookUserRepositoryCacheDecorator(
            $userRepository,
            $cache
        );

        return $this;
    }

    public function persist(CookUser $cook): CookUser
    {
        return $this->repository->persist($cook);
    }

    public function getById(int $id): CookUser
    {
        return $this->repository->getById($id);
    }
}