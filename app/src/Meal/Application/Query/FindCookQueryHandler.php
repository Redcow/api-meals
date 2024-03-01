<?php

namespace App\Meal\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\ICookUserRepository;

#[QueryHandler]
final readonly class FindCookQueryHandler
{
    public function __construct(
        private ICookUserRepository $repository
    ) {}

    public function __invoke(FindCookIQuery $query): CookUser
    {
        return $this->repository->getById($query->id);
    }
}