<?php

declare(strict_types=1);

namespace App\Order\Application\Command;

use App\Common\Application\Command\ICommand;
use App\Common\Domain\Entity\Collection;
use App\Order\Domain\Entity\ClientUser;
use App\Order\Infrastructure\ApiPlatform\Input\ArticleInput;

final readonly class CreateOrderICommand implements ICommand
{
    public function __construct(
        /** @var Collection<ArticleInput> */
        public Collection $articles,
        public ClientUser $client
    ) {}
}