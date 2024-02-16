<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\Messenger;

use App\Common\Application\Query\QueryBusInterface;
use App\Common\Application\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @template T
     * @param QueryInterface<T> $query
     * @return T
     */
    public function ask(QueryInterface $query): mixed
    {
        return $this->handle($query);
    }
}