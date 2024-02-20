<?php

namespace App\Meal\Domain\Entity;

use App\Common\Domain\Entity\User;

final readonly class CookUser extends User
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
            email: $email,
            password: $password,
            username: $username,
            roles: $roles,
            id: $id,
        );
    }
}