<?php

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;

#[QueryHandler]
final readonly class FindCookQueryHandler
{
    public function __construct(
        private CookUserRepositoryInterface $repository
    ) {}

    public function __invoke(FindCookQuery $query): CookUser
    {
        return $this->repository->getById($query->id);
    }
}