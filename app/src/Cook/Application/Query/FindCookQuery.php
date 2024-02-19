<?php

namespace App\Cook\Application\Query;

use App\Common\Application\Query\QueryInterface;

final readonly class FindCookQuery implements QueryInterface
{
    public function __construct(
        public int $id
    ) {}
}