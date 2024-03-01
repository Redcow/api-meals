<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\ICommand;
use App\Meal\Domain\Entity\CookUser;

/**
 * @implements ICommand<CookUser>
 */
final readonly class CreateCookICommand implements ICommand
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username
    ){}
}