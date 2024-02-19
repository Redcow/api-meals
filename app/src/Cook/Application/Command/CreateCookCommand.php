<?php

namespace App\Cook\Application\Command;

use App\Common\Application\Command\CommandInterface;
use App\Cook\Domain\Entity\Cook;

/**
 * @implements CommandInterface<Cook>
 */
final readonly class CreateCookCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username
    ){}
}