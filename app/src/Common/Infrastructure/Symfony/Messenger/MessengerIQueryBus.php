<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\Messenger;

use App\Common\Application\Query\IQueryBus;
use App\Common\Application\Query\IQuery;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerIQueryBus implements IQueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @template T
     * @param IQuery<T> $query
     * @return T
     */
    public function ask(IQuery $query): mixed
    {
        return $this->handle($query);
    }
}