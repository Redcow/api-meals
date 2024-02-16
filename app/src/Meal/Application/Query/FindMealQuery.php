<?php

declare(strict_types=1);

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryInterface;

final readonly class FindMealQuery implements QueryInterface
{
    public function __construct(
        public int $id
    ) {}
}