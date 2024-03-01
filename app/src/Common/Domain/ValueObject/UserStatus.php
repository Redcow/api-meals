<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

enum UserStatus : string
{
    case OFF = "OFF";

    case ON = "ON";
    case BLOCKED = "BLOCKED";

    public function isEnabled(): bool
    {
        return $this === self::ON;
    }
}