<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\ICookUserRepository;

#[CommandHandler]
final readonly class UpdateCookCommandHandler
{
    public function __construct(
       private ICookUserRepository $repository
    ){}

    public function __invoke(UpdateCookICommand $command): CookUser
    {
        $cook = $this->repository->getById($command->id);

        return $this->repository->persist(
            $cook->with(username: $command->username)
        );
    }

}