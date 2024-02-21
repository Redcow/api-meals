<?php

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;

#[CommandHandler]
class UpdateCookCommandHandler
{
    public function __construct(
       private CookUserRepositoryInterface $repository
    ){}

    public function __invoke(UpdateCookCommand $command): CookUser
    {
        $cook = $this->repository->getById($command->id);

        xdebug_break();

        return $this->repository->persist(
            $cook->with(username: $command->username)
        );
    }
}