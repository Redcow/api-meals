<?php

declare(strict_types=1);

namespace App\Common\Application\Command;

interface ICommandBus
{
    /**
     * @template T
     * @param ICommand<T> $command
     * @return T
     */
    public function dispatch(ICommand $command): mixed;
}