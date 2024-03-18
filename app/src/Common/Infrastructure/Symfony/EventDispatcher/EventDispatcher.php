<?php

namespace App\Common\Infrastructure\Symfony\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventDispatcher
{
    public function __construct(
        private readonly EventDispatcherInterface $dispatcher
    ) {}

    public function dispatch(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}