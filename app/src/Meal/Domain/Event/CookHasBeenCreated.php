<?php

namespace App\Meal\Domain\Event;

use App\Common\Domain\Event\Event;
use App\Meal\Domain\Entity\CookUser;

final readonly class CookHasBeenCreated extends Event
{
    public function __construct(
        public CookUser $cook
    ){}

}