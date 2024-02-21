<?php

namespace App\Meal\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBusInterface;
use App\Meal\Application\Query\FindCookQuery;
use App\Meal\Infrastructure\ApiPlatform\Resource\CookUserResource;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProviderInterface<CookUserResource>
 */
final readonly class CookItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private Security                   $security
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CookUserResource
    {
        $query = new FindCookQuery($uriVariables['id']);

        $cook = $this->queryBus->ask($query);

        return CookUserResource::fromDomain($cook);
    }
}