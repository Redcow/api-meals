<?php

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;

#[CommandHandler]
final readonly class CreateCookCommandHandler
{
    public function __construct(
        private CookUserRepositoryInterface $repository
    ){}

    public function __invoke(CreateCookCommand $command): CookUser
    {
        $cook = new CookUser(
            $command->email,
            $command->password,
            $command->username,
            ['ROLE_COOK']
        );

        return $this->repository->persist($cook);
    }
}