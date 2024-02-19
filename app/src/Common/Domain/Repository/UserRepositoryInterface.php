<?php

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\User;

/**
 * @template T of User
 */
interface UserRepositoryInterface
{
    /**
     * @param T $user
     * @return T
     */
    public function persist($user);

    /**
     * @return T
     */
    public function getOne(int $id);
}