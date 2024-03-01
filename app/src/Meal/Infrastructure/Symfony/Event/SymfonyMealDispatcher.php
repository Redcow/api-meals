<?php

namespace App\Meal\Infrastructure\Symfony\Event;

use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Service\IMealDispatcher;

class SymfonyMealDispatcher implements IMealDispatcher
{

    public function dispatchCookHasBeenCreated(CookUser $cook)
    {
        // TODO: Implement dispatchCookHasBeenCreated() method.
    }
}