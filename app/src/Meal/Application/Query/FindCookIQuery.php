<?php

namespace App\Meal\Application\Query;

use App\Common\Application\Query\IQuery;

final readonly class FindCookIQuery implements IQuery
{
    public function __construct(
        public int $id
    ) {}
}