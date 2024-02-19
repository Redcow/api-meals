<?php

namespace App\Cook\Domain\Repository;

use App\Common\Domain\Repository\UserRepositoryInterface;
use App\Cook\Domain\Entity\Cook;

/***
 * @implements UserRepositoryInterface<Cook>
 */
interface CookRepositoryInterface extends UserRepositoryInterface
{
    /**
     * @param Cook $user
     * @return Cook
     */
    public function persist($user): Cook;

    public function getOne(int $id): Cook;
}