<?php

namespace App\Order\Application\Command;

use App\Common\Application\Command\CommandInterface;
use App\Order\Domain\Entity\ClientUser;

/**
 * @implements CommandInterface<ClientUser>
 */
final readonly class CreateClientUserCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username
    ){}
}