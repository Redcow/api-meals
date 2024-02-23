<?php

namespace App\Order\Application\Command;

use App\Common\Application\Command\CommandInterface;

final readonly class AddArticleCommand implements CommandInterface
{
    public function __construct(
        public int $meal,
        public int $quantity = 1
    ){}
}