<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandInterface;
use App\Meal\Infrastructure\Doctrine\Entity\CookUser;

/**
 * @implements CommandInterface<CookUser>
 */
final readonly class UpdateCookCommand implements CommandInterface
{
    public function __construct(
        public int $id,
        public string $username
    ) {}
}