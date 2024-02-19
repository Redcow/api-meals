<?php

namespace App\Cook\Domain\Entity;

use App\Common\Domain\Entity\User;

final readonly class Cook extends User
{
    public function __construct(
        string $email,
        string $password,
        string $username,
        array $roles = [],
        ?int $id = null,
    ){
        if(!in_array('ROLE_COOK', $roles)) {
            $roles[] = ['ROLE_COOK'];
        }
        parent::__construct(
            $email,
            $password,
            $username,
            $roles,
            $id,
        );
    }
}