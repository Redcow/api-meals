<?php

namespace App\Meal\Domain\Service;

use App\Meal\Domain\Entity\CookUser;

interface IMealDispatcher
{
    public function dispatchCookHasBeenCreated(CookUser $cook);
}