<?php

namespace App\Meal\Application\Query;

use App\Common\Application\Query\IQuery;
use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;

/**
 * @implements IQuery<Collection<Meal>>
 */
final readonly class FindMealCollectionIQuery implements IQuery
{
    public function __construct(
        public array $ids
    ) {}
}