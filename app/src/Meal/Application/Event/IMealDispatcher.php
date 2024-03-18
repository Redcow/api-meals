<?php

namespace App\Meal\Application\Event;

use App\Meal\Domain\Entity\CookUser;

interface IMealDispatcher
{
    public function registerListeners(): void;

    public function dispatchCookHasBeenCreated(CookUser $cookUser): void;
}