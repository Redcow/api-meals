<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBusInterface;
use App\Meal\Application\Query\FindMealQuery;
use App\Meal\Infrastructure\ApiPlatform\Resource\MealResource;

/**
 * @implements ProviderInterface<MealResource>
 */
readonly class MealItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $bus
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): MealResource
    {
        $query = new FindMealQuery($uriVariables['id']);

        $meal = $this->bus->ask($query);

        // TODO 1. arreter le nullable et gérer proprement le result
        // ici en bout de chaine, pas de result pattern

        // TODO 2. configurer doctrine dans l'arbo
        // ne bouger que petit bout par petit bout l'archi > versionner !!!

        // TODO 3. nettoyer les anciens fichiers des travaux de tatonnement avec la doc
        // Conserver le decorator redis
        // Trouvez la façon indus de lier Redis à Doctrine !!!

        return MealResource::fromDomain($meal);
    }
}