<?php

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandInterface;
use App\Meal\Domain\Entity\CookUser;

/**
 * @implements CommandInterface<CookUser>
 */
final readonly class CreateCookCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username
    ){}
}