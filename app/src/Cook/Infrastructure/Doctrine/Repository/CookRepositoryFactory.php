<?php

namespace App\Cook\Infrastructure\Doctrine\Repository;

use App\Common\Application\Cache\AppCacheInterface;
use App\Cook\Domain\Entity\Cook;
use App\Cook\Domain\Repository\CookRepositoryInterface;
use App\Common\Infrastructure\Doctrine\Repository\UserRepository as UserDoctrineRepository;
use App\Cook\Infrastructure\Redis\Cache\CacheCookRepositoryDecorator;

class CookRepositoryFactory implements CookRepositoryInterface
{
    private CookRepositoryInterface $repository;

    public function __invoke(
        UserDoctrineRepository $userRepository,
        AppCacheInterface $cache
    ): CookRepositoryInterface
    {
        $this->repository = new CacheCookRepositoryDecorator($userRepository, $cache);
        return $this;
    }

    /**
     * @param Cook $user
     * @return Cook
     */
    public function persist($user): Cook
    {
        return $this->repository->persist($user);
    }

    public function getOne(int $id): Cook
    {
        return $this->repository->getOne($id);
    }
}