<?php

namespace App\Common\Domain\Event;

interface IEventDispatcher
{
    public function dispatch(Event $event): void;
}