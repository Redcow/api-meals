<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Order\Domain\Entity\ClientUser;
use App\Order\Domain\Repository\IClientUserRepository;

#[CommandHandler]
final readonly class CreateClientUserCommandHandler
{
    public function __construct(
        private IClientUserRepository $repository
    ) {}

    public function __invoke(CreateClientUserICommand $command): ClientUser
    {
        $clientUser = new ClientUser(
            email: $command->email,
            password: $command->password,
            username: $command->username
        );

        return $this->repository->persist($clientUser);
    }
}