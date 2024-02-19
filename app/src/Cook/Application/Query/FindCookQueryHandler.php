<?php

namespace App\Cook\Application\Query;

use App\Common\Application\Query\QueryHandler;
use App\Cook\Domain\Entity\Cook;
use App\Cook\Domain\Repository\CookRepositoryInterface;

#[QueryHandler]
final readonly class FindCookQueryHandler
{
    public function __construct(
        private CookRepositoryInterface $repository
    ) {}

    public function __invoke(FindCookQuery $query): Cook
    {
        return $this->repository->getOne($query->id);
    }
}