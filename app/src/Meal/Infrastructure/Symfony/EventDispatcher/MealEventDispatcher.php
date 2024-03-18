<?php

namespace App\Meal\Infrastructure\Symfony\EventDispatcher;

use App\Common\Infrastructure\Symfony\EventDispatcher\EventDispatcher;
use App\Meal\Application\Event\CookHasBeenCreated;
use App\Meal\Application\Event\IMealDispatcher;
use App\Meal\Domain\Entity\CookUser;

readonly class MealEventDispatcher implements IMealDispatcher
{
    public function __construct(private EventDispatcher $dispatcher)
    {}

    public function registerListeners(): void
    {
        // TODO: Implement registerListeners() method.
    }

    public function dispatchCookHasBeenCreated(CookUser $cookUser): void
    {
        $this->dispatcher->dispatch(new CookHasBeenCreated($cookUser));
    }
}