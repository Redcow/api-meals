<?php

namespace App\Meal\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\IQueryBus;
use App\Meal\Application\Query\FindCookIQuery;
use App\Meal\Infrastructure\ApiPlatform\Resource\CookUserResource;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProviderInterface<CookUserResource>
 */
final readonly class CookItemProvider implements ProviderInterface
{
    public function __construct(
        private IQueryBus $queryBus,
        private Security  $security
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CookUserResource
    {
        $query = new FindCookIQuery($uriVariables['id']);

        $cook = $this->queryBus->ask($query);

        return CookUserResource::fromDomain($cook);
    }
}