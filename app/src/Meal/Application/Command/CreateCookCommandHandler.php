<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Application\Event\IMealDispatcher;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\ICookUserRepository;

#[CommandHandler]
final readonly class CreateCookCommandHandler
{
    public function __construct(
        private ICookUserRepository $repository,
        private IMealDispatcher     $dispatcher,
    )
    {
    }

    public function __invoke(CreateCookICommand $command): CookUser
    {
        $cook = new CookUser(
            $command->email,
            $command->password,
            $command->username,
            ['ROLE_COOK']
        );

        $persistedCook = $this->repository->persist($cook);

        $this->dispatcher->dispatchCookHasBeenCreated($cook);

        return $persistedCook;
    }
}