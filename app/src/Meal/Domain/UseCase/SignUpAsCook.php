<?php

declare(strict_types=1);

namespace App\Meal\Domain\UseCase;

use App\Common\Domain\Event\IEventDispatcher;
use App\Common\Domain\UseCase\UseCase;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Event\CookHasBeenCreated;
use App\Meal\Domain\Repository\ICookUserRepository;

final readonly class SignUpAsCook extends UseCase
{
    public function __construct(
        private ICookUserRepository $repository,
        IEventDispatcher            $dispatcher
    ){
        parent::__construct($dispatcher);
    }
    public function execute($request, $response): void
    {
        $cook = new CookUser(
            $request->getUserEmail(),
            $request->getUserPassword(),
            $request->getUsername(),
            [CookUser::ROLE]
        );

        $this->repository->persist($cook);

        $this->dispatcher->dispatch(new CookHasBeenCreated($cook));

        // fait partie du usecase la partie envoi d'un code/token pour permettre à l'utilisateur de s'activer

        // todo créer le token

        // envoyer via un notifier, la façon n'a pas d'importance, c'est un détail

        //$response->set
    }
}