<?php

namespace App\Order\Application\Command;

use App\Common\Application\Command\ICommand;

final readonly class AddArticleICommand implements ICommand
{
    public function __construct(
        public int $meal,
        public int $quantity = 1
    ){}
}