<?php

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryInterface;
use App\Common\Domain\Entity\Collection;
use App\Meal\Domain\Entity\Meal;

/**
 * @implements QueryInterface<Collection<Meal>>
 */
final readonly class FindMealCollectionQuery implements QueryInterface
{
    public function __construct(
        public array $ids
    ) {}
}