<?php

namespace App\Cook\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBusInterface;
use App\Cook\Application\Query\FindCookQuery;
use App\Cook\Infrastructure\ApiPlatform\Resource\CookResource;

/**
 * @implements ProviderInterface<CookResource>
 */
class CookItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CookResource
    {
        $query = new FindCookQuery($uriVariables['id']);

        $cook = $this->queryBus->ask($query);

        return CookResource::fromDomain($cook);
    }
}