<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\Entity\User;

final readonly class ClientUser extends User
{
    public function __construct(
        string $email,
        string $password,
        string $username,
        array $roles = [],
        ?int $id = null,
    ){
        if(!in_array('ROLE_CLIENT', $roles)) {
            $roles[] = ['ROLE_CLIENT'];
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