<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\ICommand;
use App\Meal\Infrastructure\Doctrine\Entity\CookUser;

/**
 * @implements ICommand<CookUser>
 */
final readonly class UpdateCookICommand implements ICommand
{
    public function __construct(
        public int $id,
        public string $username
    ) {}
}