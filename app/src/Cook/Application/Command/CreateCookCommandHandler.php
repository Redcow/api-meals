<?php

namespace App\Cook\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Cook\Domain\Entity\Cook;
use App\Cook\Domain\Repository\CookRepositoryInterface;

#[CommandHandler]
final readonly class CreateCookCommandHandler
{
    public function __construct(
        private CookRepositoryInterface $repository
    ){}

    public function __invoke(CreateCookCommand $command): Cook
    {
        $cook = new Cook(
            $command->email,
            $command->password,
            $command->username,
            ['ROLE_COOK']
        );

        $user = $this->repository->persist($cook);

        return $cook->with(
            id: $user->id,
            roles: $user->roles
        );
    }
}