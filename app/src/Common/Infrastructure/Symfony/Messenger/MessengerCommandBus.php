<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\Messenger;

use App\Common\Application\Command\CommandBusInterface;
use App\Common\Application\Command\CommandInterface;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @template T
     * @param CommandInterface<T> $command
     * @return T
     */
    public function dispatch(CommandInterface $command): mixed
    {
        return $this->handle($command);
    }
}