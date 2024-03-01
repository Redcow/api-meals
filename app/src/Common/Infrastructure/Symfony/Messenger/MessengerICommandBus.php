<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\Messenger;

use App\Common\Application\Command\ICommandBus;
use App\Common\Application\Command\ICommand;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerICommandBus implements ICommandBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @template T
     * @param ICommand<T> $command
     * @return T
     */
    public function dispatch(ICommand $command): mixed
    {
        return $this->handle($command);
    }
}