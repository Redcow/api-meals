<?php

namespace App\Common\Application\Query;

interface QueryBusInterface
{
    /**
     * @template T
     * @param QueryInterface<T> $query
     * @return T
     */
    public function ask(QueryInterface $query): mixed;
}