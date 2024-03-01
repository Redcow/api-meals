<?php

namespace App\Common\Application\Query;

interface IQueryBus
{
    /**
     * @template T
     * @param IQuery<T> $query
     * @return T|T[]|null
     */
    public function ask(IQuery $query): mixed;
}