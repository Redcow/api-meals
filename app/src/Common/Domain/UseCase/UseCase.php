<?php

namespace App\Common\Domain\UseCase;

use App\Common\Domain\Event\IEventDispatcher;

readonly class UseCase
{
    public function __construct(
        protected IEventDispatcher $dispatcher
    ) {}
}