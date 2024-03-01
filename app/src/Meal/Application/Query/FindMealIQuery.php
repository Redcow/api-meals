<?php

declare(strict_types=1);

namespace App\Meal\Application\Query;

use App\Common\Application\Query\IQuery;

final readonly class FindMealIQuery implements IQuery
{
    public function __construct(
        public int $id
    ) {}
}