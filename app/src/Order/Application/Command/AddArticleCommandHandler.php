<?php

namespace App\Order\Application\Command;

use App\Common\Application\Command\CommandHandler;

#[CommandHandler]
final readonly class AddArticleCommandHandler
{
    public function __construct(
        //private BasketRepositoryInterface $repository
    ){}

    public function __invoke(AddArticleICommand $command): void
    {
        $user = null;
        //$basket = $this->repository->getUserBasket($user, withArticles: true);
        // retrouver le panier ou le créer si not exist

        // créer l'article en base

        // ajouter l'article au panier

        // vérification si l'article est tjs dispo
    }
}