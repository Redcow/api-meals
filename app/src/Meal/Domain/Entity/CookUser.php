<?php

namespace App\Meal\Domain\Entity;

use App\Common\Domain\Entity\User;

final readonly class CookUser extends User
{
    public const ROLE = 'ROLE_COOK';
}