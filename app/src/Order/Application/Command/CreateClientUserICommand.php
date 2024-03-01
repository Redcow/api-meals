<?php

namespace App\Order\Application\Command;

use App\Common\Application\Command\ICommand;
use App\Order\Domain\Entity\ClientUser;

/**
 * @implements ICommand<ClientUser>
 */
final readonly class CreateClientUserICommand implements ICommand
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username
    ){}
}